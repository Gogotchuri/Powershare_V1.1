<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamMemberSocialLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_member_social_links', function (Blueprint $table) {
            $table->increments("id");
            $table->text("url");

            $table->unsignedInteger("team_member_id");
            $table->foreign("team_member_id")->references("id")->on("team_members")->onDelete("cascade");

            $table->unsignedInteger("platform_id");
            $table->foreign("platform_id")->references("id")->on("social_platforms")->onDelete("cascade");

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
        Schema::dropIfExists('team_member_social_links');
    }
}
