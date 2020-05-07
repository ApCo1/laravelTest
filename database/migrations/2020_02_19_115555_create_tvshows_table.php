<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvshowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvshows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('rating',3,1)->default(0);
            $table->integer('no_reviews')->default(0);
            $table->string('name',200);
            $table->string('metaphone',200);
            $table->year('year_of_release');
            $table->year('year_of_end')->nullable();
            $table->integer('duration');
            $table->integer('total_watchtime')->default(0);
            $table->string('image',255);
            $table->string('info',500);
            $table->integer('no_seasons')->default(0);
            $table->integer('no_episodes')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvshows');
    }
}
