<?php

class Location extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'locations';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $fillable = array('fb_id');

	public function events()
 	{
     	return $this->hasMany('Event');
 	}
}
