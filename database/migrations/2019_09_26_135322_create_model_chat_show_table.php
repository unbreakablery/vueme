<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelChatShowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_chat_show', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id')->unsigned();
            $table->integer('credits_price')->unsigned()->nullable()->default(0);
            $table->string('show_type', 255)->nullable()->default(null);
            $table->string('description', 255)->nullable()->default(null);
            $table->string('hashtags', 255)->nullable()->default(null);
            $table->string('title', 255)->nullable()->default(null);
            $table->smallInteger('default_video')->nullable()->default(0);
            $table->smallInteger('show_gift')->nullable()->default(1);
            $table->timestamp('started_at')->nullable()->default(null);
            $table->timestamp('ended_at')->nullable()->default(null);
            $table->timestamp('notify_email_at')->nullable()->default(null);
            $table->timestamp('notify_sms_at')->nullable()->default(null);
            $table->timestamp('notify_sns_at')->nullable()->default(null);
            $table->foreign('model_id', 'model_chat_show_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('model_chat_show');
    }
}
