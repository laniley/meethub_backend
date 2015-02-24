<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('fb_id')->unique();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('picture')->nullable();
			$table->string('gender')->nullable();
			$table->string('locale', 2)->nullable();
			$table->boolean('first_login')->default(true);
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
		Schema::dropIfExists('users');
	}

}
