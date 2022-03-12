<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoroscopeInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horoscope_info', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->date('start_week')->nullable();
            $table->date('end_week')->nullable();
            $table->unsignedBigInteger('horoscope_zodiac_signs_id')->nullable();
            
            $table->unsignedBigInteger('match_id1')->nullable();
            $table->string('subject1', 255)->nullable()->default(null);
            $table->unsignedBigInteger('match_id2')->nullable();
            $table->string('subject2', 255)->nullable()->default(null);
            $table->unsignedBigInteger('match_id3')->nullable();
            $table->string('subject3', 255)->nullable()->default(null);

            $table->text('content')->nullable();
            $table->integer('hustle')->default(0);
            $table->integer('love')->default(0);
            $table->integer('outlook')->default(0);
            $table->integer('vibe')->default(0);
            $table->timestamps();


            $table->foreign('horoscope_zodiac_signs_id')->references('id')->on('horoscope_zodiac_signs') ->onDelete('cascade');
            
            $table->foreign('match_id1')->references('id')->on('horoscope_zodiac_signs');
            $table->foreign('match_id2')->references('id')->on('horoscope_zodiac_signs');
            $table->foreign('match_id3')->references('id')->on('horoscope_zodiac_signs');
            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horoscope_info');
    }
}
