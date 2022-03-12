<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->boolean('status')->default(0);
        });


        DB::update('update languages
                SET status = 1
                WHERE id=43 or id=157 or id=50');


    }

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
