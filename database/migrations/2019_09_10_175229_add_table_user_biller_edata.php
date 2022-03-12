<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableUserBillerEdata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_biller_edata', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->string('billing_id',255);
            $table->string('last_four',4)->nullable();
            $table->string('type',16)->nullable();
            $table->string('test_mode',4)->nullable()->default('live');
            $table->tinyInteger('preferred')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('user_biller_edata', function(Blueprint $table)
        {
            $table->foreign('user_id', 'FK_user_biller_edata_user')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
