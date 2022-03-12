<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_device', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('ip')->nullable();
            $table->string('browser',255)->nullable();
            $table->string('system',50)->nullable();
            $table->string('device',255)->nullable();
            $table->string('device_name',255)->nullable();
            $table->timestamps();
        });

        Schema::table('user_device', function(Blueprint $table)
        {
            $table->foreign('user_id', 'user_device_ibfk_1')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_device');
    }
}
