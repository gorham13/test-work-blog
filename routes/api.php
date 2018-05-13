<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('signup', 'UsersController@createUser');

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('account', 'AuthController@account');

    
});

// Route::group(['middleware' => 'jwt.auth'], function () {
    Route::patch('change-role/{id}', 'UsersController@changeRole');
    Route::get('users', 'UsersController@getUsers');

    Route::post('blog', 'BlogController@createBlogPost');
    Route::get('blog', 'BlogController@getBlogPosts');
    Route::get('blog/{id}', 'BlogController@getBlogPost');
    Route::post('blog/{id}', 'BlogController@updateBlogPost');
    Route::delete('blog/{id}', 'BlogController@deleteBlogPost');

    Route::post('comment', 'CommentController@createComment');
    // Route::get('comment', 'CommentController@getComments');
    Route::patch('comment/{id}', 'CommentController@updateComment');
    Route::delete('comment/{id}', 'CommentController@deleteComment');
// });
