<?php

class MeethubCommentController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user_id = Input::get('user');

		$user = User::findOrFail($user_id);

		// test the DB-Connection
		try
	   {
	      $pdo = DB::connection('mysql')->getPdo();
	   }
	   catch(PDOException $exception)
	   {
	      return Response::make('Database error! ' . $exception->getCode() . ' - ' . $exception->getMessage());
	   }

	   $meethubs = [];
	   $comments = [];

	   $meethubMemberships_of_user = MeethubMembership::where('user_id', '=', $user_id)->get();

	   foreach ($meethubMemberships_of_user as $membership)
		{
			if(!in_array($membership->meethub_id, $meethubs))
				array_push($meethubs, $membership->meethub_id);
		}

	   foreach ($meethubs as $meethub)
		{
			$comments_of_meethub = MeethubComment::where('meethub_id', '=', $meethub)->get();

			foreach ($comments_of_meethub as $comment_of_meethub)
			{
				array_push($comments, $comment_of_meethub);
			}
		}

	   foreach ($comments as $comment)
		{
		   $comment["author"] = $comment->user_id;
		   $comment["meethub"] = $comment->meethub_id;
		}

	   return '{ "meethubComments": ['.implode(',', $comments).'] }';
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
		$user_id = Input::get('meethubComment.author');
		$meethub_id = Input::get('meethubComment.meethub');
		$text = Input::get('meethubComment.text');

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

		$id = DB::table('meethub_comments')
			->insertGetId(
		    	array(
		    			'user_id' => $user_id,
		    			'meethub_id' => $meethub_id,
		    			'text' => $text,
		    			'created_at' => $date,
		    			'updated_at' => $date
		    		)
				);

		$meethubComment = MeethubComment::findOrFail($id);

	   return '{"meethubComment":'.$meethubComment.' }';
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

	   $comment = MeethubComment::findOrFail($id);

	   $comment["author"] = $comment["user_id"];
	   $comment["meethub"] = $comment["meethub_id"];
	   
	   return '{ "meethub-comment":'.$comment.' }';
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


// 	/**
// 	 * Update the specified resource in storage.
// 	 *
// 	 * @param  int  $id
// 	 * @return Response
// 	 */
	public function update($id)
	{
		$user_id = Input::get('meethubComment.author');
		$meethub_id = Input::get('meethubComment.meethub');
		$text = Input::get('meethubComment.text');

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

		DB::table('meethub_comments')
			->where('id', $id)
			->update(
		    	array(
		    			'text' => $text
		    		)
				);

		$meethubComment = MeethubComment::findOrFail($id);

	   return '{"meethubComment":'.$meethubComment.' }';
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		MeethubComment::destroy($id);
	}


}
