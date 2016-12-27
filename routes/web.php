<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (){
//admin
    Route::get('/', function (){
        if(view()->exists('admin.index')){
            $data = ['title' => 'Administrator Panel'];
            return view('admin.index', $data);
        }
    });

    /*Route::group(['prefix' => 'users', 'middleware' => 'auth'], function (){
        Route::get('/', ['uses' => 'AdminUsersController@index', 'as' => 'users']);
    });*/

    Route::resource('users', 'AdminUsersController');
    Route::resource('posts', 'AdminPostsController');
    Route::resource('categories', 'AdminCategoriesController');
    Route::resource('media', 'AdminMediaController');


});
