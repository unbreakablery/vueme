<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_user', function (Blueprint $table) {
            $table->increments('id');                 
            $table->integer('user_id')->unsigned();
            $table->integer('appointment_id')->unsigned();
            $table->tinyInteger('subscribed');  
            $table->foreign('user_id')
                ->references('id')
                ->on('user')->onDelete('cascade');
           
            $table->foreign('appointment_id')
              ->references('id')
              ->on('appointment')->onDelete('cascade');

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
        Schema::dropIfExists('appointment_user');
    }
}
