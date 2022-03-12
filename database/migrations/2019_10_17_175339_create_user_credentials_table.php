<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_credentials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('user_id_fk');
            $table->string('institution_name', 255)->nullable()->default(null);
            $table->integer('from_year')->nullable()->default(null);
            $table->integer('to_year')->nullable()->default(null);
            $table->string('degree', 255)->nullable()->default(null);
            $table->string('area_of_study', 255)->nullable()->default(null);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('user')->onUpdate('CASCADE')->onDelete('CASCADE');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_credentials');
    }
}
