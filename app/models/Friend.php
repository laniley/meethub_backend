<?php

// can not be namend Event, because this is reserved by Laravel
class Friend extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'friends';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();
	protected $fillable = array('user_id', 'friend_id', 'name');

	// public function user()
 // 	{
  //    	return $this->belongsTo('User');
 // 	}
 // 	public function friend()
 // 	{
  //    	return $this->belongsTo('User');
 // 	}
}
