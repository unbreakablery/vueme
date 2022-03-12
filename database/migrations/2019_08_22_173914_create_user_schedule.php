<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_schedule', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('user_id')->unsigned();

            $table->string('day');

            $table->boolean('active')->default(0);

            $table->time('from')->nullable();

            $table->time('till')->nullable();

            $table->softDeletes();

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
        Schema::dropIfExists('user_schedule');
    }
}
