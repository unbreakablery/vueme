<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserAppointmentLive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->integer('appointment_live')->unsigned()->nullable()->index('user_appointment_live_referral_id_fk');          
        });
        Schema::table('user', function (Blueprint $table) {          
            $table->foreign('appointment_live')->references('id')->on('appointment')->onUpdate('CASCADE')->onDelete('CASCADE');
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
