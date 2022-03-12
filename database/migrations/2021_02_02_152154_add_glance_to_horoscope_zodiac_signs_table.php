<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGlanceToHoroscopeZodiacSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('horoscope_zodiac_signs', function (Blueprint $table) {
            
            $table->string('glance_1', 50)->nullable()->default(null);
            $table->string('glance_2', 50)->nullable()->default(null);
            $table->string('glance_3', 50)->nullable()->default(null);
            $table->string('glance_4', 50)->nullable()->default(null);

            $table->string('glance_5', 50)->nullable()->default(null);
            $table->string('glance_6', 50)->nullable()->default(null);
            $table->string('glance_7', 50)->nullable()->default(null);
            $table->string('glance_8', 50)->nullable()->default(null);

            $table->string('glance_9', 50)->nullable()->default(null);
            $table->string('glance_10', 50)->nullable()->default(null);
            $table->string('glance_11', 50)->nullable()->default(null);
            $table->string('glance_12', 50)->nullable()->default(null);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('horoscope_zodiac_signs', function (Blueprint $table) {

            $table->dropColumn('glance_1');
            $table->dropColumn('glance_2');
            $table->dropColumn('glance_3');
            $table->dropColumn('glance_4');
            $table->dropColumn('glance_5');
            $table->dropColumn('glance_6');
            $table->dropColumn('glance_7');
            $table->dropColumn('glance_8');
            $table->dropColumn('glance_9');
            $table->dropColumn('glance_10');
            $table->dropColumn('glance_11');
            $table->dropColumn('glance_12');
            
        });
    }
}
