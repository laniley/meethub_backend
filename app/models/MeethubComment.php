<?php

class MeethubComment extends Eloquent {

	use SoftDeletingTrait;

	protected $table = 'meethub_comments';

	protected $dates = ['deleted_at'];

	protected $softDelete = true;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('user_id', 'meethub_id', 'updated_at', 'deleted_at');

	public function author()
 	{
     	return $this->belongsTo('User');
 	}
	public function meethub()
 	{
     	return $this->belongsTo('Meethub');
 	}
}


    