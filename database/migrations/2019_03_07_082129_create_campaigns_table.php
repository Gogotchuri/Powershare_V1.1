<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\References\CampaignStatus;
class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("campaigns", function (Blueprint $table) {
            $table->increments("id");
            
            $table->string("name");
            $table->text("details")->nullable();

            $table->unsignedInteger("author_id")->nullable();
            $table->foreign("author_id")->references("id")->on("users")->onDelete("set null");
            
            $table->unsignedInteger("status_id")->default(CampaignStatus::DRAFT);
            $table->foreign("status_id")->references("id")->on("campaign_statuses");

            $table->string("video_url")->nullable();
            
            $table->string("ethereum_address")->nullable();

            $table->unsignedInteger("category_id")->nullable();
            $table->foreign("category_id")->references("id")->on("campaign_categories")->onDelete("set null");
            
            $table->unsignedDecimal("required_funding")->default(0);

            $table->unsignedDecimal("realized_funding")->default(0);
            $table->dateTime("funding_checked_at")->nullable();

            $table->integer("order")->nullable();
            $table->boolean("is_hidden")->default(false);

            $table->unsignedInteger("location_id")->nullable();
            $table->foreign("location_id")->references("id")->on("locations")->onDelete("set null");

            $table->softDeletes();

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
        Schema::dropIfExists("campaigns");
    }
}
