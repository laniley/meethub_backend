<?php

class FriendController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$user_id = Input::get('user_id');
		$friend_id = Input::get('friend_id');

		// test the DB-Connection
		try {
	    $pdo = DB::connection('mysql')->getPdo();
	  }
	  catch(PDOException $exception) {
	    return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	  }

		$friends = new Friend();

		if(isset($user_id)) {
			$friends = $friends->where('user_id', $user_id);
	  }

		if(isset($friend_id)) {
			$friends = $friends->where('friend_id', $friend_id);
	  }

		$friends = $friends->get();

	  return '{ "friends": '.$friends.'}';
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$friend = Friend::firstOrCreate(array(
			'user_id' => Input::get('friend.user_id'),
			'friend_id' => Input::get('friend.friend_id')
		));

		$friend->name = Input::get('friend.name');

		$friend->save();

	  return '{"friend":'.$friend.' }';
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {
		$friend = Friend::findOrFail($id);
	  return '{"friend":'.$friend.' }';
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		// test the DB-Connection
		try {
	    $pdo = DB::connection('mysql')->getPdo();
	  }
	  catch(PDOException $exception) {
	    return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	  }

		$friend = Friend::findOrFail($id);

		$friend->name = Input::get('friend.name');
		$friend->has_been_seen = Input::get('friend.has_been_seen');

		$friend->save();

	  return '{"friend":'.$friend.' }';
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
