<?php

class MeethubInvitationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user_id = Input::get('invited_user');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   $invites = MeethubMembership::where('user_id', '=', $user_id)->get();
	   $meethubs = [];
	   $messages = [];

	   foreach ($invites as $invite)
		{
		   $invite["invited_user"] = $invite->user_id;
		   $invite["message"] = $invite->message_id;
		   $invite["meethub"] = $invite->meethub_id;

		   $message = Message::find($invite->message_id);

		   $meethub = Meethub::find($invite->meethub_id);
		   $founder = $meethub->founder_id;
		   $meethub["founder"] = $founder;

		   $memberships_of_meethub = MeethubMembership::where('meethub_id', '=', $invite->meethub_id)->get();

		   $invitations = [];

		   foreach ($memberships_of_meethub as $membership_of_meethub)
			{
				if(!in_array($membership_of_meethub->id, $invitations))
					array_push($invitations, $membership_of_meethub->id);
			}

			$meethub["invitations"] = $invitations;
		   
		   if(!in_array($message, $messages))
		   	array_push($messages, $message);

		   if(!in_array($meethub, $meethubs))
		   	array_push($meethubs, $meethub);
		}

	   return '{ "meethubInvitations": '.$invites.', "messages": ['.implode(',', $messages).'], "meethubs": ['.implode(',', $meethubs).'] }';
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
		$to_id = Input::get('meethubInvitation.invited_user');
		$meethub_id = Input::get('meethubInvitation.meethub');
		$message_id = Input::get('meethubInvitation.message');
		$status = Input::get('meethubInvitation.status');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if meethubInvitation already exists
	   $meethubInvitation = DB::table('mm_users_meethubs')
	   	->where('user_id', $to_id)
	   	->where('meethub_id', $meethub_id)
	   	->first();

	   $date = new \DateTime;

	 	// insert
	 	if($meethubInvitation)
	 	{
	 		$meethubInvitation = MeethubMembership::findOrFail($meethubInvitation->id);
	 	}
	 	else
	 	{
			$id = DB::table('mm_users_meethubs')
				->insertGetId(
			    	array(
			    			'user_id' => $to_id,
			    			'meethub_id' => $meethub_id,
			    			'message_id' => $message_id,
			    			'status' => $status,
			    			'created_at' => $date,
			    			'updated_at' => $date
			    		)
					);

			$meethubInvitation = MeethubMembership::findOrFail($id);
	   }

	   return '{"meethubInvitation":'.$meethubInvitation.' }';
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   $invitation = MeethubMembership::findOrFail($id);
	   $invitation["invited_user"] = $invitation["user_id"];
	   $invitation["meethub"] = $invitation["meethub_id"];
	   $invitation["message"] = $invitation["message_id"];
	   
	   return '{ "meethub-invitation":'.$invitation.' }';
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
		$to_id = Input::get('meethubInvitation.invited_user');
		$meethub_id = Input::get('meethubInvitation.meethub');
		$status = Input::get('meethubInvitation.status');

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   // check if meethubInvitation already exists
	   $meethubInvitation = DB::table('mm_users_meethubs')->where('id', $id)->first();

	   $date = new \DateTime;

	 	// update
	 	if($meethubInvitation)
	 	{
			DB::table('mm_users_meethubs')
            ->where('id', $id)
            ->update(
            	array(
            			'status' => $status,
            			'updated_at' => $date
            		)
            	);
	   }

	   $meethubInvitation = MeethubMembership::findOrFail($id);
	   
	   return '{"meethubInvitation":'.$meethubInvitation.' }';
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
