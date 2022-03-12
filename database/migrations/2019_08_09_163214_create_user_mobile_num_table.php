<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserMobileNumTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_mobile_num', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('mobile_user_ibfk_1');
			$table->string('number', 20)->unique('number');
			$table->boolean('validated')->default(0);
			$table->boolean('active')->default(1);
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
		Schema::drop('user_mobile_num');
	}

}
