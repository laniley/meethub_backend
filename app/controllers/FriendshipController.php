<?php

class FriendshipController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user_id = Input::get('user');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   $friendships = Friendship::where('user_id', '=', $user_id)->get();
	   $users = [];
	   $friends = [];

	   foreach ($friendships as $friendship)
		{
		   $friendship["user"] = $friendship->user_id;
		   $friendship["friend"] = $friendship->friend_id;

		   $user = User::find($friendship->user_id);
		   $friend = User::find($friendship->friend_id);

		   if(!in_array($user, $users))
		   	array_push($users, $user);
		   
		   if(!in_array($friend, $friends))
		   	array_push($friends, $friend);
		}

	   return '{ "users": '.$invites.', "events": ['.implode(',', $events).'], "invited_users": ['.implode(',', $users).'], "messages": ['.implode(',', $messages).'], "locations": ['.implode(',', $locations).'] }';
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
