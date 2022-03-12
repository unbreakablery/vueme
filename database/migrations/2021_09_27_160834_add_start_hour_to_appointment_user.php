<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStartHourToAppointmentUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_user', function (Blueprint $table) {
            $table->timestamp('start_time')->nullable()->default(null);            
            $table->double('duration')->default(0);
            $table->tinyInteger('in_stream')->default(1); 
            $table->double('credits_per_minute');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_user', function (Blueprint $table) {
            //
        });
    }
}
