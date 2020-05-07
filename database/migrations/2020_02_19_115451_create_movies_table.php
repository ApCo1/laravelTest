<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('rating',3,1)->default(0);
            $table->integer('no_reviews')->default(0);
            $table->string('name',200);
            $table->string('metaphone',200);
            $table->year('year_of_release');
            $table->integer('duration');
            $table->string('image',255);
            $table->string('info',500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
