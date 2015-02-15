<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMmUsersMeethubsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mm_users_meethubs', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('meethub_id')->unsigned();
			$table->integer('message_id')->unsigned()->nullable();
			$table->string('status')->default('pending');
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('meethub_id')->references('id')->on('meethubs');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mm_users_meethubs');
	}

}
