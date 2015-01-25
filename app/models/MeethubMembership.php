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
	public function user()
 	{
     	return $this->belongsTo('User');
 	}
	public function meethub()
 	{
     	return $this->belongsTo('Meethub');
 	}
}
