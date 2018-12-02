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
use App\Events\MessagePushed;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/posts/{page}', 'PostController@index')->name('posts.index');

Route::get('/post/create', 'PostController@create');

Route::post('/post/save', 'PostController@store');

Route::get('/post/{post}', 'PostController@show')->name('post.show');

Route::post('/post/update', 'PostController@update');

Route::post('/post/get', 'PostController@postInfo');

Route::get('/post/edit/{post}', 'PostController@edit')->name('post.edit');

Route::post('/post/destroy', 'PostController@destroy');

Route::post('/visit', 'PostController@visit');

Route::get('/posts/{page}/all', 'PostController@postAll');

Route::post('/post/image/store', 'PostController@imageStore');

Route::post('/post/image/update', 'PostController@imageUpdate');

Route::get('/users/{user}', 'UserController@show')->name('user.show');

Route::get('/users/{user}/follow', 'UserController@follow')->name('user.follow');

Route::get('/users/{user}/unfollow', 'UserController@unfollow')->name('user.unfollow');

Route::post('/users/follow', 'UserController@followpost');

Route::post('/users/unfollow', 'UserController@unfollowpost');


Route::get('/following/{id}/list', 'UserController@followingList');

Route::get('/follower/{id}/list', 'UserController@followerList');

Route::get('/following/{user}/list/{page}', 'UserController@followingListPage');

Route::get('/follower/{user}/list/{page}', 'UserController@followerListPage');

Route::post('/user/image/store', 'UserController@imageStore');

Route::post('/user/image/update', 'UserController@imageUpdate');

Route::get('/settings', 'UserController@settings')->middleware('auth')->name('user.settings');

Route::post('/changePassword','UserController@showChangePassword');

Route::post('/changeEmail','UserController@showChangeEmail');

Route::delete('/delete/{id}/works','UserController@destroyWorks');

Route::delete('/delete/{id}/user','UserController@destroy');

Route::post('/update/info', 'UserController@updateInfo');

Route::get('/chat/{id?}', 'ChatController@index')->name('chat');

Route::get('/my/chats', 'ChatController@chatList')->name('chat');

Route::post('/find/chat/user', 'ChatController@openChat');

Route::post('/find/chat/poli/user', 'ChatController@openPoliChat');

Route::post('/update/chat/title', 'ChatController@updateTitle')->name('chat');

Route::post('/leave/chatroom', 'ChatController@leaveChat')->name('chat');

Route::post('/find/userlist/chat', 'ChatController@findUser');

Route::post('/find/companion/info', 'ChatController@companionInfo');

Route::post('/chat/state', 'ChatController@chatState');

Route::get('/message/{chat_id}/{page}', 'MessageController@index')->name('message');

Route::post('/message', 'MessageController@store')->name('message.store');

Route::post('/read/message', 'MessageController@read');

Route::post('/read/message/one', 'MessageController@readOne');
 
Route::get('/comments/{comment}/{page}', 'CommentController@index');
 
Route::post('/comment/edit', 'CommentController@update');

Route::post('/comment/delete', 'CommentController@destroy');

Route::post('/comments', 'CommentController@store');

Route::post('/reply', 'CommentController@storeReply');

Route::post('/favorite/{post}', 'PostController@favoritePost');

Route::post('/unfavorite/{post}', 'PostController@unFavoritePost');

Route::get('/my_favorites', 'UserController@myFavorites')->middleware('auth')->name('favorite');

Route::post('/portfolio/info', 'PortfolioController@indexInfo');

Route::post('/portfolio/showInfo', 'PortfolioController@showInfo');
Route::get('/portfolio/{id}/list', 'PortfolioController@show');

Route::get('/portfolio/create', 'PortfolioController@create');

Route::post('/portfolio/save', 'PortfolioController@store');

Route::put('/portfolio/{id}/update', 'PortfolioController@update');

Route::get('/portfolio/{id}/edit', 'PortfolioController@edit');

Route::get('/portfolio/{user_id?}', 'PortfolioController@index');

Route::delete('/portfolio/{id}', 'PortfolioController@destroy');

Broadcast::routes();

Route::get('/event', function() {
	event(new MessagePushed('porqui?'));
	return 'event';
});
