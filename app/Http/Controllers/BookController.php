<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    //

    protected $book;

    public function __construct(Book $book)
    {
      $this->book=$book;
    }

    public function storeBooks(Request $req){
        $validation=Validator::make($req->all(),[
              'book_name'=>'required',
              'author'=>'required',
              'published_date'=>'required',
              'price'=>'required',
              'language'=>'required'
        ]);

        if($validation->fails()){
            return response()->json([
                   'status'=>true,
                   'message'=>$validation->errors(),
                   'status_code'=>'422'
            ]);
        }
         else
        $this->book::create([
          'book_name'=>$req->book_name,
          'author'=>$req->author,
          'published_date'=>$req->published_date,
          'price'=>$req->price,
          'language'=>$req->language
        ]);
        return response()->json([
             'status'=>true,
             'message'=>"Data Save Successfully",
             'status_code'=>'200'
        ]);
    }

    public function showBooks(){
        $data=$this->book::all();
        return response()->json([
            'status'=>true,
            'message'=>"Data Fetched",
            'Books-Data'=>[$data],
            'status_code'=>'200'
        ]);
    }

    public function updateBooks(Request $req,$id){
          $validation=Validator::make($req->all(),[
            'book_name'=>'required',
            'author'=>'required',
            'published_date'=>'required',
            'price'=>'required',
            'language'=>'required',

          ]);
          if($validation->fails()){
            return response()->json([
                'status'=>true,
                'message'=>$validation->errors(),
                'status_code'=>'422'
            ]);
          }
          else {
            $book=$this->book->find($id);
            $book->book_name=$req->book_name;
            $book->author=$req->author;
            $book->published_date=$req->published_date;
            $book->price=$req->price;
            $book->language=$req->language;
            $book->update();

            return response()->json([
                'status'=>true,
                'message'=>"Data Updated Successfully",
                'status_code'=>'200',
            ]);
          }

    }

    public function deleteBooks($id){
        $book=$this->book->find($id)->delete();
        return response()->json([
            'status'=>true,
            'message'=>"Data Delete successfully",
            'status_code'=>'200'
        ]);
    }

}
