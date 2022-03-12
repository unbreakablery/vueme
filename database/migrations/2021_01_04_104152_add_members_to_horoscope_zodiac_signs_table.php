<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMembersToHoroscopeZodiacSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('horoscope_zodiac_signs', function (Blueprint $table) {
            
            $table->text('about')->nullable();
            $table->string('start_period')->nullable();
            $table->string('end_period')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string("subtitle")->nullable()->default("");
            $table->string('slug', 255)->nullable()->default(null);
            $table->text('title_tag')->nullable()->default(null);
            $table->text('meta_desc_tag')->nullable()->default(null);
            $table->string('seo_headline', 255)->nullable()->default(null);
            $table->string('seo_img_path', 255)->nullable()->default(null);
            $table->text('seo_content')->nullable();
            $table->string('seo_hero_path',255)->nullable()->default(null);
            $table->text('seo_hero_content')->nullable()->default(null);


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

            $table->dropColumn('about');
            $table->dropColumn('start_period');
            $table->dropColumn('end_period');
            $table->dropColumn('logo');
            $table->dropColumn('banner');
            $table->dropColumn('subtitle');
            $table->dropColumn('slug');
            $table->dropColumn('title_tag');
            $table->dropColumn('meta_desc_tag');
            $table->dropColumn('seo_headline');
            $table->dropColumn('seo_img_path');
            $table->dropColumn('seo_content');
            $table->dropColumn('seo_hero_path');
            $table->dropColumn('seo_hero_content');

        });
    }
}
