<?php

// can not be namend Event, because this is reserved by Laravel
class MeethubMembership extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'mm_users_meethubs';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('user_id', 'meethub_id', 'message_id', 'created_at', 'updated_at');

	public function user()
 	{
     	return $this->belongsTo('User');
 	}
	public function meethub()
 	{
     	return $this->belongsTo('Meethub');
 	}
}
