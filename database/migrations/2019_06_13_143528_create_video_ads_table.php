<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->nullable(true);
            $table->string("url");
            //TODO not nullable?
            $table->unsignedInteger("advertisers_id")->nullable();
            $table->foreign("advertisers_id")->references("id")->on("advertisers")->onDelete("set null");
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
        Schema::dropIfExists('video_ads');
    }
}
