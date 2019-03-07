<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("team_members", function (Blueprint $table) {
            $table->increments("id");

            $table->unsignedInteger("campaign_id");
            $table->foreign("campaign_id")->references("id")->on("campaigns");

            $table->string("name");

            $table->unsignedInteger("image_id")->default(0);
            $table->foreign("image_id")->references("id")->on("images");

            $table->unsignedInteger("powershare_user_id")->nullable();
            $table->foreign("powershare_user_id")->references("id")->on("users")->onDelete("set null");
            
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
        Schema::dropIfExists("team_members");
    }
}
