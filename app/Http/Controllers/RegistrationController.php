<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\PasswordRest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegistrationController extends BaseController
{
    //


    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function logout()
    {

        Auth::logout();
        return response()->json([
            'status' => true,
            'message' => 'Logout successfully',
            'status_code' => '200',

        ]);
    }



    public function forgetPassword(Request $req){
        try{

            // $validation = Validator::make($req->all, [
            //     'email' => 'required|email|exists:users,email'
            // ]);
            $email=User::where('email',$req->email)->get();
            if (count($email) > 0) {
                   $token=Str::random(30);
                   $domain=URL::to('/');
                   $url=$domain. '/reset-password?token='.$token;
                  
                   $data['url']=$url;
                   $data['title']="Reset Password";
                   $data['email']=$req->email;
                   $data['message']="Please reset your email password";

           

                   Mail::send('forgtePassword', ['data'=>$data], function ($message) use ($data) {
                    
                       $message->to($data['email']);
                       $message->subject('Reset your Password');
                  
                   });
                     $dateTime=Carbon::now()->format('Y-m-d H:i:s');
                   PasswordRest::updateOrCreate(
                    ['email'=>$req->email  ],
                   [
                     'email'=>$req->email,
                     'token'=>$token,
                     'created_at'=>$dateTime
                   ]
                );

                return response()->json([
                    'success'=>true,
                    'message'=>'Please check your email to reset password'
                ]);
            } 
            else {
                return response()->json([
                    'success' => false,
                    'message' => "Email is not valid"
                ]);
            }
        }
       catch(\Exception $e){
          return response()->json([
            'success'=>false,
            'message'=>$e->getMessage()
          ]);
       }
    }

    public function resetPassword(Request $req){

        $resetData=PasswordRest::where('token',$req->token)->get();
        if(isset($req->token) && count($resetData) >0 )
        {
            $userData=User::where('email',$resetData[0]['email'])->get();
            return view('resetPassword',compact('userData'));
        }
       else{
        echo "Token not found";
       }
    }

    

    public function newPassword(Request $request)
    {

        // dd($request->email);
        // // echo "New Password function";
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required|min:6',
        //     're-enter-password' => 'required|min:6|same:password'
        // ]);
        DB::table('users')->where('email', $request->email)->update([
            'password' => $request->password,
        ]);
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return "<h1>Password change successfully</h1>";
    
    }
}
