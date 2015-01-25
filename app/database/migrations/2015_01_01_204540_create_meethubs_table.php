<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeethubsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meethubs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('short_description')->nullable();
			$table->integer('founder_id')->unsigned();
			$table->timestamps();

			$table->foreign('founder_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('meethubs');
	}

}
