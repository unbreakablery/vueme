<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancelByToUser11ChatRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_1_1_chat_request', function (Blueprint $table) {
            $table->integer('canceled_by')->default(null)->nullable();    
            $table->boolean('canceled_notify_view')->default(0);    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_1_1_chat_request', function (Blueprint $table) {
            //
        });
    }
}
