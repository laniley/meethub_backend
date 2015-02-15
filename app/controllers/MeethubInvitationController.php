<?php

class MeethubInvitationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user_id = Input::get('invited_user');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	 //   $invites = EventInvitation::where('user_id', '=', $user_id)->get();
	 //   $events = [];
	 //   $users = [];
	 //   $messages = [];
	 //   $locations = [];

	 //   foreach ($invites as $invite)
		// {
		//    $invite["event"] = $invite->event_id;
		//    $invite["invited_user"] = $invite->user_id;
		//    $invite["message"] = $invite->message_id;

		//    $event = myEvent::find($invite->event_id);
		//    $event["location"] = $event->location_id;

		//    $user = User::find($invite->user_id);
		//    $message = Message::find($invite->message_id);
		//    $location = Location::find($event->location_id);

		//    if(!in_array($event, $events))
		//    	array_push($events, $event);

		//    if(!in_array($location, $locations))
		//    	array_push($locations, $location);

		//    if(!in_array($user, $users))
		//    	array_push($users, $user);
		   
		//    if(!in_array($message, $messages))
		//    	array_push($messages, $message);
		// }

	 //   return '{ "eventInvitations": '.$invites.', "events": ['.implode(',', $events).'], "invited_users": ['.implode(',', $users).'], "messages": ['.implode(',', $messages).'], "locations": ['.implode(',', $locations).'] }';
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
		$to_id = Input::get('meethubInvitation.invited_user');
		$meethub_id = Input::get('meethubInvitation.meethub');
		$message_id = Input::get('meethubInvitation.message');
		$status = Input::get('meethubInvitation.status');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if meethubInvitation already exists
	   $meethubInvitation = DB::table('mm_users_meethubs')
	   	->where('user_id', $to_id)
	   	->where('meethub_id', $meethub_id)
	   	->first();

	   $date = new \DateTime;

	 	// insert
	 	if($meethubInvitation)
	 	{
	 		$meethubInvitation = MeethubMembership::findOrFail($meethubInvitation->id);
	 	}
	 	else
	 	{
			$id = DB::table('mm_users_meethubs')
				->insertGetId(
			    	array(
			    			'user_id' => $to_id,
			    			'meethub_id' => $meethub_id,
			    			'message_id' => $message_id,
			    			'status' => $status,
			    			'created_at' => $date,
			    			'updated_at' => $date
			    		)
					);

			$meethubInvitation = MeethubMembership::findOrFail($id);
	   }

	   return '{"meethubInvitation":'.$meethubInvitation.' }';
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   $invitation = MeethubMembership::findOrFail($id);
	   $invitation["invited_user"] = $invitation["user_id"];
	   $invitation["meethub"] = $invitation["meethub_id"];
	   $invitation["message"] = $invitation["message_id"];
	   
	   return '{ "meethub-invitation":'.$invitation.' }';
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
	  //  $eventInvitation = DB::table('mm_users_events')->where('id', $id)->first();

	  //  $date = new \DateTime;

	 	// // update
	 	// if($eventInvitation)
	 	// {
			// $id = $eventInvitation->id;

	 	// 	DB::table('mm_users_events')
   //          ->where('id', $id)
   //          ->update(
   //          	array(
   //          			'status' => $status,
   //          			'updated_at' => $date
   //          		)
   //          	);
	  //  }

	  //  $eventInvitation = EventInvitation::findOrFail($id);
	   
	  //  return '{"eventInvitation":'.$eventInvitation.' }';
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
