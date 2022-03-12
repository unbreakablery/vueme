<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoroscopeAdminConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horoscope_admin_config', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emails')->nullable();
            $table->string('subject')->nullable();
            $table->timestamp('date')->nullable()->default(null);
            $table->string('timezone', 50)->nullable()->default(null);
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
        Schema::dropIfExists('horoscope_admin_config');
    }
}
