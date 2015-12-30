<?php

class MessageController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$to_user_id = Input::get('to_user_id');
		$fb_id = Input::get('fb_id');
		$type = Input::get('message_type');

		// test the DB-Connection
		try {
	    $pdo = DB::connection('mysql')->getPdo();
	  }
	  catch(PDOException $exception) {
	    return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	  }

		$messages = new Message();

		if(isset($to_user_id)) {
			$messages = $messages->where('to_user_id', $to_user_id);
	  }

	  if(isset($fb_id)) {
			$messages = $messages->where('fb_id', $fb_id);
	  }

		if(isset($type)) {
			$messages = $messages->where('message_type', $type);
	  }


		$messages = $messages->get();

	  return '{ "messages": '.$messages.' }';
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		// test the DB-Connection
		try {
	    $pdo = DB::connection('mysql')->getPdo();
	  }
	  catch(PDOException $exception) {
	    return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	  }

		$message = Message::firstOrCreate(array(
			'fb_id' => Input::get('message.fb_id'),
			'message_type' => Input::get('message.message_type'),
			'to_user_id' => Input::get('message.to_user_id')
		));

		$message->from_user_id = Input::get('message.from_user_id');
		$message->subject = Input::get('message.subject');
		$message->text = Input::get('message.text');

		$message->save();

	  return '{ "message":'.$message.' }';
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		$subject = Input::get('message.subject');
		$text = Input::get('message.text');
		$has_been_seen = Input::get('message.has_been_seen');

		// test the DB-Connection
		try {
	    $pdo = DB::connection('mysql')->getPdo();
	  }
	  catch(PDOException $exception) {
	    return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	  }

	  // check if message already exists
	  $message = DB::table('messages')->where('id', $id)->first();

	  $date = new \DateTime;

	 	// update message - because it already exists
	 	if($message) {
	 		$id = $message->id;

	 		DB::table('messages')
            ->where('id', $id)
            ->update(
            	array(
            			'subject' => $subject,
            			'text' => $text,
            			'has_been_seen' => $has_been_seen,
            			'updated_at' => $date
            		)
            	);
	 	}

	   $message = Message::findOrFail($id);

	   return '{ "message":'.$message.' }';
	}
}
