<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

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
    return view('welcome');
});

Route::get('/home',[BlogController::class, 'index']);
Route::get('/about',[BlogController::class, 'about']);
Route::get('/article',[BlogController::class, 'article']); // this is the post.html
Route::get('/contact',[BlogController::class, 'contact']);
Route::post('/contact',[BlogController::class, 'contactForm']);