<?php

class EventInvitationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$user_id = Input::get('invited_user_id');
		$event_id = Input::get('event_id');

		// test the DB-Connection
		try {
	    $pdo = DB::connection('mysql')->getPdo();
	  }
	  catch(PDOException $exception) {
	    return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	  }

		$invites = new EventInvitation();

		if(isset($event_id)) {
			$invites = $invites->where('event_id', $event_id);
		}

		if(isset($user_id)) {
			$invites = $invites->where('user_id', $user_id);
		}

		$invites = $invites->get();

	  $events = [];
	  $users = [];
	  $messages = [];
	  $locations = [];

	   foreach ($invites as $invite) {
		   $invite["event"] = $invite->event_id;
		   $invite["invited_user"] = $invite->user_id;
		   $invite["message"] = $invite->message_id;

		   $event = myEvent::find($invite->event_id);
		   $event["location"] = $event->location_id;

		   $user = User::find($invite->user_id);
		   $message = Message::find($invite->message_id);
		   $location = Location::find($event->location_id);

		   if(!in_array($event, $events))
		   	array_push($events, $event);

		   if(!in_array($location, $locations))
		   	array_push($locations, $location);

		   if(!in_array($user, $users))
		   	array_push($users, $user);

		   if(!in_array($message, $messages))
		   	array_push($messages, $message);
		}

	   return '{ "eventInvitations": '.$invites.' }';
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$event_id = Input::get('eventInvitation.event_id');
		$user_id = Input::get('eventInvitation.invited_user_id');
		$message_id = Input::get('eventInvitation.message_id');
		$status = Input::get('eventInvitation.status');

		// test the DB-Connection
		try {
	    $pdo = DB::connection('mysql')->getPdo();
	  }
	  catch(PDOException $exception) {
	    return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	  }

		$eventInvitation = EventInvitation::firstOrCreate(array(
			'user_id' => $user_id,
			'event_id' => $event_id
		));

		$eventInvitation->message_id = $message_id;
		$eventInvitation->status = $status;

		$eventInvitation->save();

	  return '{"eventInvitation":'.$eventInvitation.' }';
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		$status = Input::get('eventInvitation.status');
		$message_id = Input::get('eventInvitation.message_id');
		// test the DB-Connection
		try {
	    $pdo = DB::connection('mysql')->getPdo();
	  }
	  catch(PDOException $exception) {
	    return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	  }

	  $eventInvitation = EventInvitation::findOrFail($id);
		$eventInvitation->status = $status;
		$eventInvitation->message_id = $message_id;
		$eventInvitation->save();

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
