<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('containers');
        Schema::create('containers', function (Blueprint $table) {
        
            $table->id();
            $table->integer('street_number')->nullable(false);
            $table->string('street_name')->nullable(false);
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            // $table->decimal('latitude', 10, 8);
            // $table->decimal('longitude', 11, 8);
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
        Schema::dropIfExists('containers');
    }
}
