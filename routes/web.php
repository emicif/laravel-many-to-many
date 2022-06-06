<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();

//non crea rotte quindi non ci si può accedere -> ti rimanda a guest!
//Auth::routes(['register'=>false, 'reset'=>false, 'verify'=>false]);

//Route::get('/home', 'HomeController@index')->name('home');


Route::middleware('auth')
    ->namespace('Admin')
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('/posts', 'PostController');
});





//Ultima dichiarata
Route::get("{any?}", function(){
    return view('guest.home');
})->where("any", ".*");
