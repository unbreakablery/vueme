<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChatUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('receiver_id')->unsigned();
            $table->longText('message')->nullable();
            $table->string('created_at_utc',255)->nullable();
            $table->string('image',255)->nullable();
            $table->tinyInteger('view')->default(0);
            $table->timestamps();
        });

        Schema::table('chat', function(Blueprint $table)
        {
            $table->foreign('user_id', 'user_chat_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('receiver_id', 'receiver_chat_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
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
