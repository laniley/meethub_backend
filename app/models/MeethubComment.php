<?php

class MeethubComment extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'meethub_comments';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('user_id', 'meethub_id', 'created_at', 'updated_at');

	public function author()
 	{
     	return $this->belongsTo('User');
 	}
	public function meethub()
 	{
     	return $this->belongsTo('Meethub');
 	}
}
