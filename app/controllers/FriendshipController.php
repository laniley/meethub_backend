<?php

class FriendshipController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user_id = Input::get('user_id');
		$friend_id = Input::get('friend_id');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   $friendships = Friendship::whereRaw('user_id = ? and friend_id = ? ', array($user_id, $friend_id))
	   						->get();

	   foreach ($friendships as $friendship)
		{
		   $friendship["user"] = $friendship["user_id"];
	   	$friendship["friend"] = $friendship["friend_id"];
		}

	   return '{ "friendships": '.$friendships.'}';
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
		$user_id = Input::get('friendship.user');
		$friend_id = Input::get('friendship.friend');

   	// check if friendship already exists
	   $friendship = DB::table('friendships')
	   			->where('user_id', $user_id)
	   			->where('friend_id', $friend_id)
	   			->first();

	   // save
	   if(!$friendship) // insert friendship
	   {
			$id = DB::table('friendships')
				->insertGetId(
			    	array(
			    			'user_id' => $user_id,
			    			'friend_id' => $friend_id
			    		)
					);
	   }
	   else
	   {
	   	$id = $friendship->id;
	   }

	   $friendship = Friendship::findOrFail($id);
	   $friendship["user"] = $friendship["user_id"];
	   $friendship["friend"] = $friendship["friend_id"];

	   return '{"friendship":'.$friendship.' }';
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
