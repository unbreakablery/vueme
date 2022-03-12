<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserMessageLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_message_log', function(Blueprint $table)
		{
			$table->foreign('user_id', 'user_message_log_ibfk_2')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_message_log', function(Blueprint $table)
		{
			$table->dropForeign('user_message_log_ibfk_2');
		});
	}

}
