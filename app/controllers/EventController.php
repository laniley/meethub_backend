<?php

class EventController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$fb_id = Input::get('fb_id');

	   // check if event already exists
   	$events = myEvent::where('fb_id', '=', $fb_id)->get();

   	$all_invites = [];

   	foreach ($events as $event)
		{
			$event = $this->loadEventData($event);
		}

	   return '{"events":'.$events.'}';
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
	  // check if event already exists
	  $event = myEvent::firstOrCreate(array(
			'fb_id' => Input::get('event.fb_id')
		));

		$event->name = Input::get('event.name');
		$event->description = Input::get('event.description');
		$event->start_time = Input::get('event.start_time');
		$event->start_date = Input::get('event.start_date');
		$event->location_id = Input::get('event.location_id');
		$event->picture = Input::get('event.picture');

		$event->save();

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

		$event = $this->loadEventData($event);

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
	public function update($id) {
	   // check if event already exists
   	$event = myEvent::findOrFail($id);

		$event->name = Input::get('event.name');
		$event->description = Input::get('event.description');
		$event->start_time = Input::get('event.start_time');
		$event->start_date = Input::get('event.start_date');
		$event->location_id = Input::get('event.location_id');

		$event->save();

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


	private function loadEventData($event)
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

		return $event;
	}

}
