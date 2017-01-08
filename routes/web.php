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

Route::get('/', ['uses' => 'BlogPostController@index', 'as' => 'index']);
Route::get('/posts/{slug}', ['uses' => 'BlogPostController@show', 'as' => 'post']);

Auth::routes();
Route::get('/user/activation/{token}', 'Auth\RegisterController@userActivation');
//Route::get('/home', 'HomeController@index');

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

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
    Route::resource('comments', 'AdminCommentsController');
    Route::resource('comment/replies', 'AdminCommentRepliesController');

    Route::group(['prefix' => 'media'], function (){

        Route::get('/', ['uses' => 'AdminMediaController@index', 'as' => 'media.index']);

        Route::get('/upload', ['uses' => 'AdminMediaController@upload', 'as' => 'media.upload']);

        Route::post('/upload', ['uses' => 'AdminMediaController@store', 'as' => 'media.upload']);

        Route::delete('/delete/{media}', ['uses' => 'AdminMediaController@delete', 'as' => 'media.delete']);
    });

    Route::group(['prefix' => 'comments'], function (){

        Route::post('/create/{id}', ['uses' => 'AdminCommentsController@createcomment', 'as' => 'comment.create']);

    });

    Route::group(['prefix' => 'profile'], function (){

        Route::get('/', ['uses' => 'AdminProfileController@index', 'as' => 'profile']);
        Route::get('/edit', ['uses' => 'AdminProfileController@edit', 'as' => 'profile.edit']);
        Route::post('/update/{id}', ['uses' => 'AdminProfileController@update', 'as' => 'profile.update']);
        Route::post('/delete', ['uses' => 'AdminProfileController@destroy', 'as' => 'profile.delete']);

    });


});
