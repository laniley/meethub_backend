<?php

// can not be namend Event, because this is reserved by Laravel
class EventInvitation extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'mm_users_events';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('event_id', 'user_id');
	protected $fillable = array('event_id', 'user_id', 'message_id');

	public function event()
 	{
     	return $this->hasOne('myEvent');
 	}
 	public function user()
 	{
     	return $this->hasOne('User');
 	}
	public function message()
 	{
     	return $this->hasOne('Message');
 	}
}
