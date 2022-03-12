<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCreditsToFloatOnModelChatRoomTable extends Migration
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
            $table->float('credits_per_minute', 9, 2)->default(0)->change();
            $table->float('credits_deducted', 9, 2)->default(0)->change();
            $table->float('credits_total', 9, 2)->default(0)->change();
            
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
