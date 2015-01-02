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
	public function users()
 	{
     	return $this->belongsToMany('User');
 	}
}
