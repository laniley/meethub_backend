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

	   return '{"user":'.$user.'}';
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
		//
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
