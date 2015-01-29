<?php

// can not be namend Event, because this is reserved by Laravel
class Friendship extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'friendships';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	public function user()
 	{
     	return $this->hasOne('User');
 	}
 	public function friend()
 	{
     	return $this->hasOne('User');
 	}
}
