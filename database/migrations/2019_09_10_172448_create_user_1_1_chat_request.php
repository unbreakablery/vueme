<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUser11ChatRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_1_1_chat_request', function (Blueprint $table) {
            $table->increments('id');
            $table->string('state', 255)->nullable()->default('ENQUEUED');
            $table->timestamp('requested_time')->nullable()->default(null);
            $table->integer('minutes_requested')->nullable()->default('5');
            $table->integer('user_id')->unsigned()->nullable()->default(null)->index('user_1_1_chat_request_user_id_ibfk_1');
            $table->integer('model_id')->unsigned()->nullable()->default(null)->index('user_1_1_chat_request_model_id_ibfk_1');
            $table->integer('model_chat_room_id')->unsigned()->nullable()->default(null)->index('user_1_1_chat_request_model_chat_room_id_ibfk_1');

            $table->foreign('user_id', 'user_id_user_1_1_chat_request_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('model_id', 'model_id_user_1_1_chat_request_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('model_chat_room_id', 'model_chat_room_id_user_1_1_chat_request_ibfk_1')->references('id')->on('model_chat_room')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamp('deleted_at')->nullable()->default(null);
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
        Schema::dropIfExists('user_1_1_chat_request');
    }
}
