<?php

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
Route::get('/hello', function () {
   // return view('welcome');
   return 'Hello World';
});
Route::get('/about', function() {
    return view('pages.about');
});
*/
// Route::get('/users/{id}/{name}', function($id, $name) {
//     return 'This is user '.$name.' with an id of '.$id;
// });

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/products', 'PagesController@products');
Route::get('/news', 'PagesController@news');
Route::get('/contacts', 'PagesController@contacts');
Route::resource('/posts', 'PostsController');

Auth::routes();
Route::get('/dashboard', 'DashboardController@index');
