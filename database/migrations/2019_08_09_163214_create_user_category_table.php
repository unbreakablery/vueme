<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_category', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->index('user_id_fk');
			$table->integer('category_id')->unsigned()->index('category_id_fk');
			$table->timestamps();
			$table->softDeletes();
			$table->unique(['user_id','category_id'], 'user_category_id_uindex');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_category');
	}

}
