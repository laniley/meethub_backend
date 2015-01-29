<?php

class UserController extends \BaseController {

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
		$fb_id = Input::get('user.fb_id');
		$first_name = Input::get('user.first_name');
		$last_name = Input::get('user.last_name');
		$picture = Input::get('user.picture');
		$gender = Input::get('user.gender');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if user already exists
	   $user = DB::table('users')
	   			->where('fb_id', $fb_id)
	   			->whereNotNull('fb_id')
	   			->first();

	   $date = new \DateTime;

	   // save login
	   if($user) // update user
	   {
	   	$id = $user->id;

	   	DB::table('users')
            ->where('id', $id)
            ->update(
            	array(
            			'picture' => $picture,
            			'updated_at' => $date
            		)
            	);
	   }
	   else // insert user
	   {
			$id = DB::table('users')
				->insertGetId(
			    	array(
			    			'fb_id' => $fb_id,
			    			'first_name' => $first_name,
			    			'last_name' => $last_name,
			    			'gender' => $gender,
			    			'picture' => $picture,
			    			'created_at' => $date,
			    			'updated_at' => $date
			    		)
					);
	   }

	   $user = User::findOrFail($id);

	   $friendships = DB::table('friendships')
				->where('user_id', '=', $id)
		      ->orWhere('friend_id', '=', $id)
		      ->get();

		$friend_ids = [];
		$friends = [];

      foreach($friendships as $friendship_object)
	   {
	   	$friendship = (array)$friendship_object;

	   	$friend_id = null;
	   	
	   	if($friendship["user_id"] != $id)
	   		$friend_id = $friendship["user_id"];
	   	else
	   		$friend_id = $friendship["friend_id"];

	   	array_push($friend_ids, $friend_id);

	   	$friend = User::findOrFail($friend_id);

	   	array_push($friends, $friend);
	   }

	   $user["friends"] = $friend_ids;

	   return '{"user":'.$user.', "friends": ['.implode(',', $friends).'] }';
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	   $user = User::findOrFail($id);

	   return '{ "user":'.$user.' }';
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
		$fb_id = Input::get('user.fb_id');
		$first_name = Input::get('user.first_name');
		$last_name = Input::get('user.last_name');
		$picture = Input::get('user.picture');
		$gender = Input::get('user.gender');
		$friends = Input::get('user.friends');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   $date = new \DateTime;

	   $user = User::findOrFail($id);

	   $user->fb_id = $fb_id;
	   $user->first_name = $first_name;
	   $user->last_name = $last_name;
	   $user->picture = $picture;
	   $user->gender = $gender;

	   $user->save();

	   // Friendships
	 //   foreach ($friends as $friend_id)
		// {
		// 	// check if friendship already exists
		//    $friendship = DB::table('friendships')
		//    				->where('user_id', $friend_id)
		//    				->orWhere('friend_id', $friend_id)
		//    				->first();

		//    $date = new \DateTime;

		//  	if(!$friendship)
		//  	{
		// 		$friendship_id = DB::table('friendships')
		// 			->insertGetId(
		// 		    	array(
		// 		    			'user_id' => $id,
		// 		    			'friend_id' => $friend_id,
		// 		    			'created_at' => $date,
		// 		    			'updated_at' => $date
		// 		    		)
		// 				);
		//    }
		// }

	   $user = User::findOrFail($id);

	   // $friends = $user->friends;

	   return '{"user":'.$user.'}';
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
