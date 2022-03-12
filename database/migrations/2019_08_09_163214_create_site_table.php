<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSiteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('domain', 16)->unique('domain');
			$table->string('display_name', 16);
			$table->string('url', 32);
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
		Schema::drop('site');
	}

}
