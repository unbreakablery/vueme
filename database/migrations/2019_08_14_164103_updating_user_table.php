<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatingUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {

            $table->dropColumn('name');
            $table->dropColumn('last_name');
            $table->dropColumn('display_name');
            $table->dropColumn('country_code');
            $table->dropColumn('birth_date');
            $table->dropColumn('gender');
            $table->timestamp('last_on')->nullable()->default(null);
            $table->integer('broadcast_cnt')->default(0);
            $table->string('contract_status', 50)->default('NONE');
            $table->unsignedInteger('user_profile_id')->nullable();
            $table->foreign('user_profile_id')->references('id')->on('user_profile') ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
}
