<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserSubscriptionAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_subscription', function (Blueprint $table) {
            $table->float('rate', 9, 2)->nullable()->default(0);
            $table->integer('user_biller_id')->unsigned()->nullable();
            $table->date('next_payment_at')->nullable();
            $table->string('status', 255)->nullable()->default(null);
            $table->foreign('user_biller_id')->references('id')->on('user_biller_edata')->nullable();
            $table->string('snapchat_id', 255)->nullable()->default(null);
            $table->string('snapchat_status', 255)->nullable()->default(null);
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
