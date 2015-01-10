<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('subject');
			$table->string('text');
			$table->boolean('hasBeenRead')->default(false);
			$table->integer('user_id')->unsigned();
			$table->integer('event_id')->unsigned();
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('event_id')->references('id')->on('events');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('messages');
	}

}