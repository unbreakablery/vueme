<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToNotifyInAppTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('notify_in_app', function(Blueprint $table)
		{
			$table->foreign('user_id', 'notify_in_app_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_message_log_id', 'user_message_log')->references('id')->on('user_message_log')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('notify_in_app', function(Blueprint $table)
		{
			$table->dropForeign('notify_in_app_ibfk_1');
			$table->dropForeign('user_message_log');
		});
	}

}
