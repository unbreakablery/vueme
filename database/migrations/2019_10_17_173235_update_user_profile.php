<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profile', function (Blueprint $table) {
            $table->dropColumn('full_body_path');
            $table->string('city', 255)->nullable()->default(null);
            $table->string('state', 10)->nullable()->default(null);
            $table->string('country', 255)->nullable()->default(null);
            $table->string('intro_video_path', 255)->nullable()->default(null);
            $table->string('intro_audio_path', 255)->nullable()->default(null);

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
        });
    }
}
