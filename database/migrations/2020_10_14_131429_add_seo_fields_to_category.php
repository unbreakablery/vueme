<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class AddSeoFieldsToCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('category', function (Blueprint $table) {
            $table->string('seo_headline', 255)->nullable()->default(null);
            $table->string('seo_img_path', 255)->nullable()->default(null);
            $table->text('seo_content')->nullable();
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
            $table->dropColumn('seo_headline');
            $table->dropColumn('seo_img_path');
            $table->dropColumn('seo_content');
        });
    }
}
