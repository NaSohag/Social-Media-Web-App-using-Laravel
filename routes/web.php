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
})->name('root');


Route::post('/register',[
	'uses' => 'UserController@register',
	'as' => 'register'
]);

Route::post('/login',[
	'uses' => 'UserController@logIn',
	'as' => 'login'
]);

Route::get('/logout',[
	'uses' => 'UserController@logOut',
	'as' => 'logout'
]);

//-------------------------- chatting

Route::get('/chatting/{op_user_id}',[
	'uses' => 'ChattingController@index',
	'as' => 'chatting',
	'middleware' => 'auth'
]);

Route::post('/send-msg',[
	'uses' => 'ChattingController@sendMessage',
	'as' => 'send.msg',
	'middleware' => 'auth'
]);

//---------------------------- account edit
Route::get('/account',[
	'uses' => 'UserController@userAccount',
	'as' => 'account',
	'middleware' => 'auth'
]);

Route::post('/account-update',[
	'uses' => 'UserController@updateAccount',
	'as' => 'account.update',
	'middleware' => 'auth'
]);

Route::get('/get-image/{img_url}',[
	'uses' => 'UserController@getImage',
	'as' => 'get.image'
]);

//----------------------------- user post
Route::get('/dashboard',[
	'uses' => 'PostController@dashboardView',
	'as' => 'dashboard',
	'middleware' => 'auth'
]);

Route::post('/create-post',[
	'uses' => 'PostController@createPost',
	'as' => 'post.create',
	'middleware' => 'auth'
]);

Route::post('/edit-post',[
	'uses' => 'PostController@editPost',
	'as' => 'post.edit',
	'middleware' => 'auth'
]);

Route::get('/delete-post/{post_id}',[
	'uses' => 'PostController@deletePost',
	'as' => 'post.delete',
	'middleware' => 'auth'
]);

Route::post('/like-dislike-post',[
	'uses' => 'PostController@postLikeDislike',
	'as' => 'post.like.dislike',
	'middleware' => 'auth'
]);

Route::post('create-comment',[
	'uses' => 'PostController@createComment',
	'as' => 'comment.create',
	'middleware' => 'auth'
]);

Route::get('delete-comment/{comment_id}',[
	'uses' => 'PostController@deleteComment',
	'as' => 'comment.delete',
	'middleware' => 'auth'
]);