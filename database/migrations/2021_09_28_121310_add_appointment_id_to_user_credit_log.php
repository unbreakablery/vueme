<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAppointmentIdToUserCreditLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_credit_log', function (Blueprint $table) {
            $table->integer('appointment_id')->unsigned()->nullable();
            $table->foreign('appointment_id')
            ->references('id')
            ->on('appointment')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_credit_log', function (Blueprint $table) {
            //
        });
    }
}
