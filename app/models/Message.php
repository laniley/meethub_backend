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
	protected $hidden = array();
	protected $fillable = array('fb_id', 'message_type', 'to_user_id');

	public function eventInvitation()
 	{
     	return $this->hasOne('EventInvitation');
 	}

 	public function user()
 	{
     	return $this->belongsTo('User');
 	}
}
