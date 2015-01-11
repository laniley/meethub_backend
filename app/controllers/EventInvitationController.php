<?php

class EventInvitationController extends \BaseController {

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
		$event_id = Input::get('eventInvitation.event');
		$user_id = Input::get('eventInvitation.invited_user');
		$message_id = Input::get('eventInvitation.message');
		$status = Input::get('eventInvitation.status');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if eventInvitation already exists
	   $eventInvitation = DB::table('mm_users_events')
	   	->where('user_id', $user_id)
	   	->where('event_id', $event_id)
	   	->first();

	   // $eventInvitation = EventInvitation::whereRaw('user_id = ? and event_id = ? and user_id IS NOT NULL and event_id IS NOT NULL', array($user_id, $event_id))->get();

	   $date = new \DateTime;

	 	// insert
	 	if($eventInvitation)
	 	{
	 		$eventInvitation = EventInvitation::findOrFail($eventInvitation->id);
	 	}
	 	else
	 	{
			$id = DB::table('mm_users_events')
				->insertGetId(
			    	array(
			    			'event_id' => $event_id,
			    			'user_id' => $user_id,
			    			'message_id' => $message_id,
			    			'status' => $status,
			    			'created_at' => $date,
			    			'updated_at' => $date
			    		)
					);

			$eventInvitation = EventInvitation::findOrFail($id);
	   }

	   return '{"eventInvitation":'.$eventInvitation.' }';
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
		$status = Input::get('eventInvitation.status');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if eventInvitation already exists
	   $eventInvitation = DB::table('mm_users_events')->where('id', $id)->first();

	   $date = new \DateTime;

	 	// update
	 	if($eventInvitation)
	 	{
			$id = $eventInvitation->id;

	 		DB::table('mm_users_events')
            ->where('id', $id)
            ->update(
            	array(
            			'status' => $status,
            			'updated_at' => $date
            		)
            	);
	   }

	   $eventInvitation = EventInvitation::findOrFail($id);
	   
	   return '{"eventInvitation":'.$eventInvitation.' }';
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
