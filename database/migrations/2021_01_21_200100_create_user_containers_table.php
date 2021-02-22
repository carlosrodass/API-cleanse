<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user__containers', function (Blueprint $table) {
          
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('container_id')->constrained();
            $table->integer('points')->nullable(false);
            $table->integer('trash_kilograms')->nullable(false);
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
        Schema::dropIfExists('user__containers');
    }
}
