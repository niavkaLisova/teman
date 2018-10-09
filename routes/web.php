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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/posts', 'PostController@index')->name('posts.index');

Route::get('/post/create', 'PostController@create');

Route::post('/post/save', 'PostController@store');

Route::get('/post/{post}', 'PostController@show')->name('post.show');

Route::post('/post/update', 'PostController@update');

Route::post('/post/get', 'PostController@postInfo');

Route::get('/post/edit/{post}', 'PostController@edit')->name('post.edit');

Route::post('/post/destroy', 'PostController@destroy');

Route::post('/visit', 'PostController@visit');

Route::get('/posts/all', 'PostController@postAll');

Route::post('/post/image/store', 'PostController@imageStore');

Route::post('/post/image/update', 'PostController@imageUpdate');

Route::get('/users/{user}', 'UserController@show')->name('user.show');

Route::get('/users/{user}/follow', 'UserController@follow')->name('user.follow');

Route::get('/users/{user}/unfollow', 'UserController@unfollow')->name('user.unfollow');

Route::get('/chat', 'ChatController@index')->name('chat');

Route::get('/message', 'MessageController@index')->name('message');

Route::post('/message', 'MessageController@store')->name('message.store');
 
Route::get('/comments/{comment}/{page}', 'CommentController@index');
 
Route::post('/comment/edit', 'CommentController@update');

Route::post('/comment/delete', 'CommentController@destroy');

Route::post('/comments', 'CommentController@store');

Route::post('/reply', 'CommentController@storeReply');

Route::post('/favorite/{post}', 'PostController@favoritePost');

Route::post('/unfavorite/{post}', 'PostController@unFavoritePost');

Route::get('/my_favorites', 'UserController@myFavorites')->middleware('auth')->name('favorite');
