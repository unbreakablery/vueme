<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableChatIn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_in', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('receiver_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('chat', function(Blueprint $table)
        {
            $table->foreign('user_id', 'user_chat_in_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('receiver_id', 'receiver_chat_in_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_chat_in');
    }
}
