<?php

class MessageController extends \BaseController {

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

	   $messages = Message::where('to_user_id', '=', $user_id)->get();

	   foreach ($messages as $message)
		{
			$message["from_user"] = $message->from_user_id;
		   $message["to_user"] = $message->to_user_id;

		   $eventInvitation = DB::table('mm_users_events')->where('message_id', $message->id)->first();
		   $meethubInvitation = DB::table('mm_users_meethubs')->where('message_id', $message->id)->first();

		   if($eventInvitation)
		   	$message["eventInvitation"] = $eventInvitation->id;
		   else
		   	$message["eventInvitation"] = null;

		   if($meethubInvitation)
		   	$message["meethubInvitation"] = $meethubInvitation->id;
		   else
		   	$message["meethubInvitation"] = null;
		}

	   return '{ "messages": '.$messages.' }';
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
		$id = Input::get('message.id');
		$fb_id = Input::get('message.fb_id');
		$from_user_id = Input::get('message.from_user');
		$to_user_id = Input::get('message.to_user');
		$subject = Input::get('message.subject');
		$text = Input::get('message.text');
		
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
	   if($id !== null)
	   {
	   	$message = DB::table('messages')
	   				->where('id', $id)
	   				->whereNotNull('id')
	   				->first();
	   }
	   else
	   {
	   	$message = DB::table('messages')
	   				->where('fb_id', $fb_id)
	   				->whereNotNull('fb_id')
	   				->first();
	   }
	   

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
			    			'text' => $text,
			    			'updated_at' => $date
            		)
            	);
	 	}
	 	// save message - because it doesn't already exist
	   else
	   {
			$id = DB::table('messages')
				->insertGetId(
			    	array(
			    			'fb_id' => $fb_id,
			    			'from_user_id' => $from_user_id,
			    			'to_user_id' => $to_user_id,
			    			'subject' => $subject,
			    			'text' => $text,
			    			'created_at' => $date,
			    			'updated_at' => $date
			    		)
					);
	   }

	   $message = Message::findOrFail($id);

	   return '{ "message":'.$message.' }';
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
		$text = Input::get('message.text');
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
            			'text' => $text,
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
