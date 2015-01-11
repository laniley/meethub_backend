<?php

class MessageController extends \BaseController {

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
		$fb_id = Input::get('message.fb_id');
		$subject = Input::get('message.subject');
		$user_id = Input::get('message.user');
		// $event_id = Input::get('message.event');

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
	   $message = DB::table('messages')->where('fb_id', $fb_id)->first();

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
			    			'user_id' => $user_id,
			    			// 'event_id' => $event_id,
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
			    			'subject' => $subject,
			    			'user_id' => $user_id,
			    			// 'event_id' => $event_id,
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
