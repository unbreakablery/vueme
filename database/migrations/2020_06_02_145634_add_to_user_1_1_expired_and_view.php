<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToUser11ExpiredAndView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_1_1_chat_request', function (Blueprint $table) {
            $table->boolean('expired')->default(0);             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_1_1_expired_and_view', function (Blueprint $table) {
            //
        });
    }
}
