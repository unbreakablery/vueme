<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserHoroscope extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_horoscope', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->date('birth_date')->nullable();
            $table->string('email')->unique('email');
            $table->boolean('email_validated')->default(0);
            $table->boolean('email_risky')->default(0);
            $table->string('country_code', 2)->nullable()->default('US');
            $table->string('number', 20);
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
        Schema::dropIfExists('user_horoscope');
    }
}
