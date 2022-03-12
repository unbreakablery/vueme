<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profile', function (Blueprint $table) {
            //
            $table->string('tagline', 50)->nullable()->default(null);
            $table->string('elevator_pitch', 160)->nullable()->default(null);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profile', function (Blueprint $table) {
            //
              $table->dropColumn('tagline');
              $table->dropColumn('elevator_pitch');
        });
    }
}
