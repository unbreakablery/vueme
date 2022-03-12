<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserMessageLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_message_log', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('model_id')->unsigned()->index('model_id');
			$table->string('name', 32)->nullable();
			$table->string('type', 50)->nullable();
			$table->timestamps();
			$table->index(['user_id','model_id'], 'user_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_message_log');
	}

}
