<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFanChatRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fan_chat_room', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('state', 255)->nullable()->default('LIVE');
            $table->string('tokbox_user_token', 255)->nullable()->default(null);
            $table->timestamp('deleted_at')->nullable()->default(null);
            $table->integer('model_chat_room_id')->unsigned()->nullable()->default(null)->index('fan_chat_room_model_chat_room_id_ibfk_1');
            $table->foreign('model_chat_room_id', 'model_chat_room_id_fan_chat_room_ibfk_1')->references('id')->on('model_chat_room')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('user_id', 'user_chat_room_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unique(['user_id','model_chat_room_id'], 'star_chat_room_pk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fan_chat_room');
    }
}
