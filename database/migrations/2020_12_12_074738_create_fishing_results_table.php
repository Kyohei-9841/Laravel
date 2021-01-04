<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFishingResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fishing_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('position')->nullable();
            $table->string('fish_species')->nullable();
            $table->integer('size')->nullable();
            $table->string('pic')->nullable();
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
        Schema::dropIfExists('fishing_results');
    }
}
