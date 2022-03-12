<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinutesMaxToModelChatRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_chat_room', function (Blueprint $table) {
            //
               $table->integer('minutes_max')->nullable()->default('10');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('model_chat_room', function (Blueprint $table) {
            //
            $table->dropColumn('minutes_max');
        });
    }
}
