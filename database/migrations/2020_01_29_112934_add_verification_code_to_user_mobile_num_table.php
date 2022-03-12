<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVerificationCodeToUserMobileNumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_mobile_num', function (Blueprint $table) {
            $table->string('verification_code')->nullable()->default(null)->after('validated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_mobile_num', function (Blueprint $table) {
            //
        });
    }
}
