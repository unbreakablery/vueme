<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrefixToUserMobileNumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_mobile_num', function (Blueprint $table) {
            $table->integer('prefix')->nullable()->default(null)->after('code2');
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
