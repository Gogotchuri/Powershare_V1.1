<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("images", function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");

            $table->unsignedInteger("category_id")->nullable();
            $table->foreign("category_id")->references("id")->on("image_categories");
            
            $table->string("url");
            $table->string("thumbnail_url")->nullable();
            
            $table->unsignedInteger("campaign_id")->nullable();
            $table->foreign("campaign_id")->references("id")->on("campaigns")->onDelete("cascade");
            
            $table->unsignedInteger("user_id")->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("images");
    }
}
