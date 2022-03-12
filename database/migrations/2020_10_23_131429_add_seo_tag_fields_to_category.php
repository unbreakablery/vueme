<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class AddSeoTagFieldsToCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('category', function (Blueprint $table) {
            $table->text('title_tag')->nullable()->default(null);
            $table->text('meta_desc_tag')->nullable()->default(null);
            
        });
        
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropColumn('title_tag');
            $table->dropColumn('meta_desc_tag');
        });
    }
}
