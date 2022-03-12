<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUser11ChatRequestIdToUsersCreditLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_credit_log', function (Blueprint $table) {
            //

            $table->integer('user_1_1_chat_request_id')->unsigned()->nullable();;
            $table->foreign('user_1_1_chat_request_id')->references('id')->on('user_1_1_chat_request');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_credit_log', function (Blueprint $table) {
            //

            $table->dropColumn('user_1_1_chat_request_id');
        });
    }
}
