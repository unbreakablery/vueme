<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToChatAndRequestWasOnline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat', function (Blueprint $table) {
            $table->boolean('expired_online')->default(0);         
        });
        Schema::table('user_1_1_chat_request', function (Blueprint $table) {
            $table->boolean('expired_online')->default(0);   
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_and_request_was_online', function (Blueprint $table) {
            //
        });
    }
}
