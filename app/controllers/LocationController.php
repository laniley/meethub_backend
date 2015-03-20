<?php

class LocationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$fb_id = Input::get('fb_id');
		$name = Input::get('name');

		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if location already exists
   	$location = Location::where('name', '=', $name)->first();

	   return '{"locations":['.$location.']}';
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$fb_id = Input::get('location.fb_id');
		$name = Input::get('location.name');
		$country = Input::get('location.country');
		$city = Input::get('location.city');
		$zip = Input::get('location.zip');
		$street = Input::get('location.street');
		$latitude = Input::get('locaiton.latitude');
		$longitude = Input::get('location.longitude');
		$events = Input::get('location.events');

		// test the DB-Connection
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

	   $date = new \DateTime;

	 	// save location if not already exists
	 	if($location)
	 	{
	 		$id = $location->id;

	 		DB::table('locations')
            ->where('id', $id)
            ->update(
            	array(
            			'name' => $name,
			    			'country' => $country,
			    			'city' => $city,
			    			'zip' => $zip,
			    			'street' => $street,
			    			'latitude' => $latitude,
			    			'longitude' => $longitude
            		)
            	);
	 	}
	   else
	   {
			$id = DB::table('locations')
				->insertGetId(
			    	array(
			    			'fb_id' => $fb_id,
			    			'name' => $name,
			    			'country' => $country,
			    			'city' => $city,
			    			'zip' => $zip,
			    			'street' => $street,
			    			'latitude' => $latitude,
			    			'longitude' => $longitude
			    		)
					);
	   }

	   $location = Location::findOrFail($id);

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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
