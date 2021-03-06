<?php

class Meethub extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'meethubs';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('founder_id');

	public function founder()
 	{
     	return $this->hasOne('User');
 	}

 	public function members()
 	{
     	return $this->belongsToMany('User');
 	}
}
