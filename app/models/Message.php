<?php

// can not be namend Event, because this is reserved by Laravel
class Message extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'messages';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	public function eventInvitation()
 	{
     	return $this->hasOne('EventInvitation');
 	}

 	public function user()
 	{
     	return $this->hasOne('User');
 	}
}
