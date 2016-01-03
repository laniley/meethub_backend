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
		$friend = Friend::findOrFail($id);

		$friend->has_been_seen = Input::get('friend.has_been_seen');

		$friend->save();

	  return '{"friend":'.$friend.' }';
	}
}
