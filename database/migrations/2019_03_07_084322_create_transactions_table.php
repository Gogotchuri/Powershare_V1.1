<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger("platform_id")->nullable();
            $table->foreign("platform_id")->references("id")->on("transaction_platforms")->onDelete("set null");
            
            $table->unsignedDecimal("amount");
            
            $table->string("currency")->nullable();
            $table->foreign("currency")->references("abbr")->on("currencies")->onDelete("set null");
            
            $table->string("transaction_id")->nullable();

            $table->string("invoice")->nullable();

            $table->date("date");
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
        Schema::dropIfExists('transactions');
    }
}
