<?php

class EventController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
		$fb_id = Input::get('event.fb_id');
		$name = Input::get('event.name');
		$description = Input::get('event.description');
		$start_time = Input::get('event.start_time');
		$start_date = Input::get('event.start_date');
		$status = Input::get('event.status');
		$location_id = Input::get('event.location');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if event already exists
	   $event = DB::table('events')
	   				->where('fb_id', $fb_id)
	   				->whereNotNull('fb_id')
	   				->first();

	   $date = new \DateTime;

	 	// save event if not already exists
	 	if($event)
	 	{
	 		$id = $event->id;

	 		DB::table('events')
            ->where('id', $id)
            ->update(
            	array(
            			'name' => $name,
			    			'description' => $description,
			    			'start_time' => $start_time,
			    			'start_date' => $start_date,
			    			'location_id' => $location_id,
			    			'created_at' => $date,
			    			'updated_at' => $date
            		)
            	);
	 	}
	   else
	   {
			$id = DB::table('events')
				->insertGetId(
			    	array(
			    			'fb_id' => $fb_id,
			    			'name' => $name,
			    			'description' => $description,
			    			'start_time' => $start_time,
			    			'start_date' => $start_date,
			    			'location_id' => $location_id,
			    			'updated_at' => $date
			    		)
					);
	   }

	   $event = myEvent::findOrFail($id);
	   // $event->load('location');
	   // $location = Location::find($event->location_id);

	   return '{"event":'.$event.' }';
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
