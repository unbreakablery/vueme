<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('site_id')->unsigned()->default(1);
			$table->integer('role_id')->unsigned()->index('role_idFK1');
			$table->string('email')->unique('email');
			$table->string('name', 50);
			$table->string('last_name', 50);
			$table->string('display_name', 64)->default('');
			$table->string('country_code', 2)->nullable()->default('US');
			$table->boolean('email_validated')->default(0);
			$table->boolean('email_risky')->default(0);
			$table->string('password', 60);
			$table->string('account_status', 50)->default('ACTIVE');
			$table->integer('credits')->default(0);
			$table->string('remember_token', 100)->default('');
			$table->boolean('test_user')->nullable()->default(0);
			$table->dateTime('status_calls')->nullable();
			$table->dateTime('accepted_terms')->nullable();
			$table->string('content_level', 50)->default('ALL AGES ONLY');
			$table->date('birth_date')->nullable();
			$table->string('gender', 50)->default('UNSPECIFIED');
			$table->dateTime('app_used_at')->nullable();
			$table->timestamp('last_log_in')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
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
		Schema::drop('user');
	}

}
