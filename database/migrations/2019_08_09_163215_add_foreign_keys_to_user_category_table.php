<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_category', function(Blueprint $table)
		{
			$table->foreign('category_id', 'category_id_fk')->references('id')->on('category')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id', 'user_id_ibfk_1')->references('id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_category', function(Blueprint $table)
		{
			$table->dropForeign('category_id_fk');
			$table->dropForeign('user_id_ibfk_1');
		});
	}

}
