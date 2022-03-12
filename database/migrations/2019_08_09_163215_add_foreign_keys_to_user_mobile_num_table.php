<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserMobileNumTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_mobile_num', function(Blueprint $table)
		{
			$table->foreign('user_id', 'mobile_user_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_mobile_num', function(Blueprint $table)
		{
			$table->dropForeign('mobile_user_ibfk_1');
		});
	}

}
