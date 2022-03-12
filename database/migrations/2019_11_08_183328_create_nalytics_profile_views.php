<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNalyticsProfileViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_views', function (Blueprint $table) {

            $table->bigIncrements('id'); 
            $table->integer('psychic_id')->nullable()->default(null)->unsigned()->index('profile_views_psychic_id_fk');
            $table->foreign('psychic_id', 'profile_views_psychic_id_ibfk_1')->references('id')->on('user')->onDelete('CASCADE');
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
        Schema::dropIfExists('nalytics_profile_views');
    }
}
