<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->default(null)->index('message_user_id_ibfk_1');
            $table->integer('model_id')->unsigned()->nullable()->default(null)->index('message_model_id_ibfk_1');
            $table->foreign('user_id', 'user_id_message_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('model_id', 'model_id_message_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('direction', 255)->nullable()->default('FROM');
            $table->string('owner', 255)->nullable()->default(null);
            $table->string('body', 255)->nullable()->default(null);
            $table->smallInteger('viewed')->nullable()->default(0);
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
        Schema::dropIfExists('message');
    }
}
