<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWatchedVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watched_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("campaign_id")->nullable();
            $table->foreign("campaign_id")->references("id")->on("campaigns")->onDelete("set null");
            $table->unsignedInteger("video_id")->nullable();
            $table->foreign("video_id")->references("id")->on("video_ads")->onDelete("set null");
            $table->unsignedInteger("user_id");
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
        Schema::dropIfExists('watched_videos');
    }
}
