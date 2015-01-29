<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token', 'friends_of_mine', 'friend_of');


	public function meethubs()
 	{
     	return $this->belongsToMany('Meethub');
 	}

 	// friendship that I started
	// function friendsOfMine()
	// {
	//   return $this->belongsToMany('User', 'friendships', 'user_id', 'friend_id');
	//      // ->wherePivot('accepted', '=', 1) // to filter only accepted
	//      // ->withPivot('accepted'); // or to fetch accepted value
	// }

	// // friendship that I was invited to 
	// function friendOf()
	// {
	//   return $this->belongsToMany('User', 'friendships', 'friend_id', 'user_id');
	//      // ->wherePivot('accepted', '=', 1)
	//      // ->withPivot('accepted');
	// }

	// // accessor allowing you call $user->friends
	// public function getFriendsAttribute()
	// {
	//    if ( ! array_key_exists('friends', $this->relations)) 
	//    	$this->loadFriends();

	//    return $this->getRelation('friends');
	// }

	// protected function loadFriends()
	// {
	//    if ( ! array_key_exists('friends', $this->relations))
	//    {
	//       $friends = $this->mergeFriends();

	//       $this->setRelation('friends', $friends);
	//    }
	// }

	// protected function mergeFriends()
	// {
	//    return $this->friendsOfMine->merge($this->friendOf);
	// }

 	// public function messages()
 	// {
  //    	return $this->belongsToMany('Message');
 	// }
}
