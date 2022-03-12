<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserOpinion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_opinion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('user_opinion_id_fk');
            $table->integer('fan_chat_room_id')->unsigned()->index('user_opinion_fan_chat_room_id_fk');
            $table->string('opinion');
            $table->string('ticket_id', 191)->nullable();
            $table->timestamps();           
            $table->foreign('user_id')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('fan_chat_room_id')->references('id')->on('fan_chat_room')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unique(['user_id','fan_chat_room_id'], 'user_fan_chat_room_id_uindex');
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
