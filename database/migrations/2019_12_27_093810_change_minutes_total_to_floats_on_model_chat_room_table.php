<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMinutesTotalToFloatsOnModelChatRoomTable extends Migration
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

            $table->float('minutes_total', 9, 2)->default(0)->change();
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
        });
    }
}
