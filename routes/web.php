<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    echo "Test";
});


Route::get('/reset-password',[RegistrationController::class,'resetPassword'])->name('reset.password');
Route::post('/new-password',[RegistrationController::class,'newPassword'])->name('new.password');
Route::get('/test',function(){
  echo "test route";
});