<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rate', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0);
			$table->float('receive_sms', 10, 0)->default(1);
			$table->float('send_sms', 10, 0)->default(1);
			$table->float('receive_mms', 10, 0)->default(1);
			$table->float('send_mms', 10, 0)->default(1);
			$table->float('voice_minute', 10, 0)->default(1);
			$table->integer('voice_minute_min')->default(1);
			$table->float('create_network', 10, 0)->default(5);
			$table->float('ppm_stream', 10, 0)->default(1);
			$table->float('ppv_stream', 10, 0)->default(1);
			$table->float('recorded_stream', 10, 0)->default(1);
			$table->float('video_chat_minute', 10, 0)->default(1);
			$table->float('bulletin', 10, 0)->default(5);
			$table->integer('vchat_1_1_minimum_duration')->nullable()->default(5);
			$table->timestamps();
			$table->float('vchat11', 10, 0)->nullable()->default(100);
			$table->unique(['user_id','created_at'], 'user_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rate');
	}

}
