<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserCreditLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_credit_log', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('user_id');
			$table->integer('model_id')->unsigned()->index('model_id');
			$table->integer('site_id')->unsigned()->default(4);
			$table->integer('credits');
			$table->string('action', 32)->default('');
			$table->timestamps();
			$table->index(['action','created_at'], 'action');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_credit_log');
	}

}
