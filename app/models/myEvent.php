<?php

// can not be namend Event, because this is reserved by Laravel
class myEvent extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('location_id');

	public function location()
 	{
     	return $this->belongsTo('Location');
 	}
}
