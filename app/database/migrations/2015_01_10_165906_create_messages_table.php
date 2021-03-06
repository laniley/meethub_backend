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
			$table->string('fb_id')->nullable();
			$table->string('message_type')->nullable();
			$table->integer('from_user_id')->unsigned()->nullable();
			$table->integer('to_user_id')->unsigned();
			$table->string('subject');
			$table->string('text')->nullable();
			$table->boolean('has_been_seen')->default(false);
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

			$table->foreign('from_user_id')->references('id')->on('users');
			$table->foreign('to_user_id')->references('id')->on('users');
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
