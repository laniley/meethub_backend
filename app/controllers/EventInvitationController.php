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

	  return '{ "eventInvitations": '.$invites.' }';
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$event_id = Input::get('eventInvitation.event_id');
		$user_id = Input::get('eventInvitation.user_id');
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
		$has_been_seen = Input::get('eventInvitation.has_been_seen');
		// test the DB-Connection
		try {
	    $pdo = DB::connection('mysql')->getPdo();
	  }
	  catch(PDOException $exception) {
	    return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	  }

	  $eventInvitation = EventInvitation::findOrFail($id);
		$eventInvitation->status = $status;
		$eventInvitation->has_been_seen = $has_been_seen;
		$eventInvitation->save();

	  return '{"eventInvitation":'.$eventInvitation.' }';
	}
}
