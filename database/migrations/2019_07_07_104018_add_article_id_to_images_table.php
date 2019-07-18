<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArticleIdToImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->unsignedInteger("article_id")->nullable();
            $table->foreign("article_id")->references("id")->on("articles")->onDelete("cascade");
        });
      
        Schema::table("articles",  function (Blueprint $table) {
            $table->dropColumn("date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn("article_id");
        });
        Schema::table("articles",  function (Blueprint $table) {
            $table->dateTime("date");
        });
    }
}
