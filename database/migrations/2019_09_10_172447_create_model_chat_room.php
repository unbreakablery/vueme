<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelChatRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_chat_room', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id')->unsigned();
            $table->string('state', 255)->nullable()->default('WAITING');
            $table->string('tokbox_model_token', 255)->nullable()->default(null);
            $table->string('tokbox_session_id', 255)->nullable()->default(null);
            $table->integer('minutes_minimum')->nullable()->default('5');
            $table->integer('minutes_paid')->nullable()->default('0');
            $table->integer('minutes_total')->nullable()->default('0');
            $table->integer('credits_per_minute')->nullable()->default('5');
            $table->integer('credits_deducted')->nullable()->default('0');
            $table->integer('credits_total')->nullable()->default('0');
            $table->timestamp('started_at')->nullable()->default(null);
            $table->timestamp('two_minute_warning_at')->nullable()->default(null);
            $table->timestamp('ended_at')->nullable()->default(null);
            $table->timestamp('notify_email_at')->nullable()->default(null);
            $table->timestamp('notify_sms_at')->nullable()->default(null);
            $table->timestamp('notify_sns_at')->nullable()->default(null);
            $table->timestamp('deleted_at')->nullable()->default(null);
            $table->integer('minutes_requested')->nullable()->default('5');

            $table->foreign('model_id', 'model_chat_room_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');

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
        Schema::dropIfExists('model_chat_room');
    }
}
