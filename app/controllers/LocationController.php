<?php

class LocationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$fb_id = Input::get('fb_id');
		$name = Input::get('name');

		try {
	    $pdo = DB::connection('mysql')->getPdo();
	  }
	  catch(PDOException $exception) {
	    return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	  }

	   // check if location already exists
   	$location = Location::where('name', '=', $name)->first();

	  return '{"locations":['.$location.']}';
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
	  $location = Location::firstOrCreate(array(
			'fb_id' => Input::get('location.fb_id')
		));

		$location->name = Input::get('location.name');
		$location->country = Input::get('location.country');
		$location->city = Input::get('location.city');
		$location->zip = Input::get('location.zip');
		$location->street = Input::get('location.street');
		$location->latitude = Input::get('location.latitude');
		$location->longitude = Input::get('location.longitude');

	  return '{"location":'.$location.'}';
	}


	/**
	 * GET a specific resource
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$fb_id = Input::get('location.fb_id');
		$name = Input::get('location.name');

		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if location already exists
   	$location = DB::table('locations')
   					->where('fb_id', $fb_id)
   					->whereNotNull('fb_id')
   					->first();

	   if(!$location)
	   {
	   	$location = DB::table('locations')->where('name', $name)->first();
	   }

	   if($location)
	 	{
	 		$id = $location->id;

	 		$location = Location::findOrFail($id);

	   	return '{"location":'.$location.'}';
	 	}
	 	else
	 	{
	 		$location = Location::findOrFail($id);

	 		if($location)
	 		{
	 			return '{"location":'.$location.'}';
	 		}
	 		else
	 		{
	 			return 'null';
	 		}
	 	}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}
}
