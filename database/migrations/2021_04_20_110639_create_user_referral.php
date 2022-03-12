<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserReferral extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_referral', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('user_referral_id_fk');
            $table->integer('referral_id')->nullable()->unsigned()->index('referral_id_fk');
            $table->string('referral_email')->nullable();
            $table->string('action',50)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('referral_id')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_referral');
    }
}
