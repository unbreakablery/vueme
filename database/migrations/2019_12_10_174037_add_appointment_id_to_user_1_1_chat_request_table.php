<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppointmentIdToUser11ChatRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_1_1_chat_request', function (Blueprint $table) {
            //

            $table->integer('appointment_id')->unsigned()->nullable();;
            $table->foreign('appointment_id')->references('id')->on('appointment');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_1_1_chat_request', function (Blueprint $table) {
            //
            $table->dropColumn('appointment_id');
        });
    }
}
