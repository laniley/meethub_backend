<?php

class BugController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

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
		$reported_by = Input::get('bug.reported_by');
		$browserCodeName = Input::get('bug.browserCodeName');
		$browserOfficialName = Input::get('bug.browserOfficialName');
		$browserVersion = Input::get('bug.browserVersion');
		$platform = Input::get('bug.platform');
		$text = Input::get('bug.text');
		$status = Input::get('bug.status');

		$body  = "FROM: ".User::find($reported_by)->name()."\r\n \r\n";
		$body .= $text."\r\n \r\n";

		$body .= $browserCodeName . "\r\n";
      $body .= $browserOfficialName . "\r\n";
      $body .= $browserVersion . "\r\n";
      $body .= $platform . "\r\n";

		Mail::send(['text' => 'emails.blank'], array('msg' => $body), function($message)
		{
		   $message->to("info@meethub.net")->subject('Bugreport - Meethub');
		});

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

		$id = DB::table('bugs')
			->insertGetId(
		    	array(
		    			'reported_by' => $reported_by,
		    			'browserCodeName' => $browserCodeName,
		    			'browserOfficialName' => $browserOfficialName,
		    			'browserVersion' => $browserVersion,
		    			'platform' => $platform,
		    			'text' => $text,
		    			'status' => $status
		    		)
				);

	   $bug = Bug::findOrFail($id);

	   return '{"bug":'.$bug.' }';
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

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
