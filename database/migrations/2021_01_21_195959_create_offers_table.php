<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('offers');
        Schema::create('offers', function (Blueprint $table) {
          
            $table->id();
            $table->string('market_name')->nullable(false);
            $table->string('offer_name')->nullable(false);
            $table->integer('points')->nullable(false);
            $table->integer('stock')->nullable(false);
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
        Schema::dropIfExists('offers');
    }
}
