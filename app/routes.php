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

Route::resource('users', 'UserController');

Route::resource('meethubs', 'MeethubController');

Route::resource('friends', 'FriendshipController');

Route::resource('events', 'EventController');

Route::resource('eventInvitations', 'EventInvitationController');

Route::resource('locations', 'LocationController');

Route::resource('messages', 'MessageController');