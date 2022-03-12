<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->string('name', 64)->default('')->nullable();
			$table->string('description', 4095)->default('')->nullable();
			$table->double('price', null, 2)->nullable()->default(null)->unsigned();
			$table->string('type')->nullable()->default('MEDIA')->nullable();
			$table->tinyInteger('status')->default(1)->index('status')->nullable();
			$table->string('duration_period')->nullable()->default('MONTH')->nullable();
			$table->timestamps();
			$table->softDeletes()->index('deleted_at');

		});

        Schema::table('subscription', function(Blueprint $table)
		{
			$table->foreign('user_id', 'subscription_user_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription');
    }
}
