<?php

class MeethubController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$member_id = Input::get('member');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   $memberships = MeethubMembership::where('user_id', '=', $member_id)->get();

	   $meethubs = [];

		foreach ($memberships as $membership)
		{
		   $meethub = Meethub::findOrFail($membership->meethub_id);
		   $founder = $meethub->founder_id;
		   $meethub["founder"] = $founder;
		   array_push($meethubs, $meethub);
		}

	   return '{ "meethubs": ['.implode(',', $meethubs).'] }';
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
		$name = Input::get('meethub.name');
		$short_description = Input::get('meethub.short_description');

		$founder_id = Input::get('meethub.founder');
		$members_arr = Input::get('meethub.members');

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

		$id = DB::table('meethubs')
			->insertGetId(
		    	array(
		    			'name' => $name,
		    			'short_description' => $short_description,
		    			'founder_id' => $founder_id,
		    			'created_at' => $date,
		    			'updated_at' => $date
		    		)
				);

		for($i = 0; $i < count($members_arr); $i++)
		{
			DB::table('mm_users_meethubs')
			->insert(
		    	array(
		    			'user_id' => $members_arr[$i],
		    			'meethub_id' => $id,
		    			'created_at' => $date,
		    			'updated_at' => $date
		    		)
				);
		}

	   $meethub = Meethub::findOrFail($id);

	   return '{ "meethub":'.$meethub.' }';
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
		$subject = Input::get('message.subject');
		$hasBeenRead = Input::get('message.hasBeenRead');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if message already exists
	   $message = DB::table('messages')->where('id', $id)->first();

	   $date = new \DateTime;

	 	// update message - because it already exists
	 	if($message)
	 	{
	 		$id = $message->id;

	 		DB::table('messages')
            ->where('id', $id)
            ->update(
            	array(
            			'subject' => $subject,
            			'hasBeenRead' => $hasBeenRead,
            			'updated_at' => $date
            		)
            	);
	 	}

	   $message = Message::findOrFail($id);

	   return '{ "message":'.$message.' }';
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
