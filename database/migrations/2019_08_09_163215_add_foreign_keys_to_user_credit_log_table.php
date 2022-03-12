<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserCreditLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_credit_log', function(Blueprint $table)
		{
			$table->foreign('user_id', 'user_credit_log_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_credit_log', function(Blueprint $table)
		{
			$table->dropForeign('user_credit_log_ibfk_1');
		});
	}

}
