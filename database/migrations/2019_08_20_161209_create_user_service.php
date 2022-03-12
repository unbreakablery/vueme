<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_service', function (Blueprint $table) {
            $table->bigIncrements('id');
			
            $table->integer('user_id')->unsigned();
            //$table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');

            $table->integer('service_id')->unsigned();
            //$table->foreign('service_id')->references('id')->on('services');
		  
            $table->boolean('active')->default(0);

            $table->float('rate', 8, 2)->nullable();

            $table->integer('min_duration')->default(0);

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
        Schema::dropIfExists('user_service');
    }
}
