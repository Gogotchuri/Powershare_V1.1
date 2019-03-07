<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger("campaign_id")->nullable();
            $table->foreign("campaign_id")->references("id")->on("campaigns")->onDelete("set null");            

            $table->unsignedInteger("user_id")->nullable();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("set null");

            $table->unsignedInteger("transaction_id")->nullable();
            $table->foreign("transaction_id")->references("id")->on("transactions")->onDelete("cascade");

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
        Schema::dropIfExists('donations');
    }
}
