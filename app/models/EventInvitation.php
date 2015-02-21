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
	protected $hidden = array('event_id', 'user_id', 'message_id');
	
	public function event()
 	{
     	return $this->belongsTo('myEvent');
 	}
 	public function user()
 	{
     	return $this->belongsTo('User');
 	}
}
