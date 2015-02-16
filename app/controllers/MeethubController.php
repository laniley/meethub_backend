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

		   $memberships_of_meethub = MeethubMembership::where('meethub_id', '=', $membership->meethub_id)->get();

		   $invitations = [];

		   foreach ($memberships_of_meethub as $membership_of_meethub)
			{
				array_push($invitations, $membership_of_meethub->id);
			}

			$meethub["invitations"] = $invitations;

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
		$name = Input::get('meethub.name');
		$short_description = Input::get('meethub.short_description');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if meethub already exists
	   $meethub = DB::table('meethubs')->where('id', $id)->first();

	   $date = new \DateTime;

	 	// update meethub - because it already exists
	 	if($meethub)
	 	{
	 		$id = $meethub->id;

	 		DB::table('meethubs')
            ->where('id', $id)
            ->update(
            	array(
            			'name' => $name,
            			'short_description' => $short_description,
            			'updated_at' => $date
            		)
            	);
	 	}

	   $meethub = Meethub::findOrFail($id);

	   return '{ "meethub":'.$meethub.' }';
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
