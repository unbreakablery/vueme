<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotifyInAppTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notify_in_app', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('user_id');
			$table->string('body', 2048);
			$table->string('LINK')->nullable();
			$table->char('viewed', 50)->default('N');
			$table->string('category', 50)->nullable();
			$table->integer('user_message_log_id')->unsigned()->nullable()->index('user_message_lg');
			$table->timestamps();
			$table->softDeletes()->index('deleted_at');
			$table->string('avatar')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notify_in_app');
	}

}
