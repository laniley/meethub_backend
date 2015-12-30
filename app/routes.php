<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(['prefix' => 'meethubbe'], function() {

	Route::resource('users', 'UserController');

	Route::resource('meethubs', 'MeethubController');

	Route::resource('friends', 'FriendController');

	Route::resource('events', 'EventController');

	Route::resource('eventInvitations', 'EventInvitationController');

	Route::resource('meethubInvitations', 'MeethubInvitationController');

	Route::resource('meethubComments', 'MeethubCommentController');

	Route::resource('locations', 'LocationController');

	Route::resource('messages', 'MessageController');

	Route::resource('bugs', 'BugController');

});
