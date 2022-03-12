<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogEtcTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_etc_tags', function (Blueprint $table) {
            $table->increments('id');

            $table->string("tag_name")->nullable();
            $table->string("slug")->unique();
            $table->mediumText("tag_description")->nullable();

            $table->unsignedInteger("created_by")->nullable()->index()->comment("user id");

            $table->timestamps();
        });

        Schema::create('blog_etc_post_tags', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger("blog_etc_post_id")->index();
            $table->foreign('blog_etc_post_id')->references('id')->on('blog_etc_posts')->onDelete("cascade");

            $table->unsignedInteger("blog_etc_tag_id")->index();
            $table->foreign('blog_etc_tag_id')->references('id')->on('blog_etc_tags')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_etc_tags');
        Schema::dropIfExists('blog_etc_post_tags');
    }
}
