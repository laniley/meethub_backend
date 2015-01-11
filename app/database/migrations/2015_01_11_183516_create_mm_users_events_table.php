<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMmUsersEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mm_users_events', function(Blueprint $table)
		{
			$table->integer('event_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('message_id')->unsigned();
			$table->string('status');
			$table->timestamps();

			$table->primary(array('event_id', 'user_id'));
			$table->foreign('event_id')->references('id')->on('events');
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('message_id')->references('id')->on('messages');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mm_users_events');
	}

}
