<?php

class EventController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$fb_id = Input::get('fb_id');

		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if event already exists
   	$events = myEvent::where('fb_id', '=', $fb_id)->get();

   	$all_invites = [];

   	foreach ($events as $event)
		{
		   $event["location"] = $event->location_id;

		   

			$invites = EventInvitation::where('event_id', '=', $event->id)->get();

			$invite_ids = [];

			foreach ($invites as $invite)
			{

			   if(!in_array($invite["id"], $invite_ids))
					array_push($invite_ids, $invite["id"]);
			}

			$event["eventInvitations"] = $invite_ids;
		}

	   return '{"events":'.$events.'}';
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

	   // $date = new \DateTime;

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
			    			'location_id' => $location_id
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
			    			'location_id' => $location_id
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
		$event = myEvent::findOrFail($id);

		$user = DB::table('users')
	   			->where('fb_id', Request::header('user_id'))
	   			->whereNotNull('fb_id')
	   			->first();

		$invites = EventInvitation::whereRaw('event_id = ? and user_id = ?', array($event->id, $user->id))->get();

		$invite_ids = [];
		// $my_event_invitation = null;
		// $friend_event_invitation_ids = [];

		foreach ($invites as $invite)
		{
		   if(!in_array($invite["id"], $invite_ids))
				array_push($invite_ids, $invite["id"]);

			// $invited_user = User::findOrFail($invite["user_id"]);

			// if($invited_user["fb_id"] == Request::header('user_id'))
			// {
			// 	$my_event_invitation = $invite["id"];
			// }
			// else
			// {
			// 	if(!in_array($invite["id"], $friend_event_invitation_ids))
			// 		array_push($friend_event_invitation_ids, $invite["id"]);
			// }
		}

		$event["eventInvitations"] = $invite_ids;
		// $event["my_event_invitation"] = $my_event_invitation;
		// $event["friend_event_invitations"] = $friend_event_invitation_ids;

		return '{ "event":'.$event.' }';
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
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if event already exists
   	$event = myEvent::findOrFail($id);

   	$event["location"] = $event->location_id;

	   return '{"event":'.$event.'}';
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
