<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRaceCompetitors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race_competitors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('race_id')->unsigned()->index();
            $table->integer('competitor_id')->unsigned()->index();
            $table->tinyInteger('position')->unsigned();

            $table->unique(['race_id', 'competitor_id']);
            $table->foreign('race_id')->references('id')->on('races')->onDelete('cascade');
            $table->foreign('competitor_id')->references('id')->on('competitors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('race_competitors');
    }
}
