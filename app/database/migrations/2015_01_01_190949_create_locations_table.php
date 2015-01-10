<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('locations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('fb_id')->unique()->nullable();
			$table->string('name');
			$table->string('country')->nullable();
			$table->string('city')->nullable();
			$table->string('zip')->nullable();
			$table->string('street')->nullable();
			$table->string('latitude')->nullable();
			$table->string('longitude')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('locations');
	}

}
