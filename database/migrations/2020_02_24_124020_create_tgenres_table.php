<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tgenres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tvshow_id');
            $table->foreign('tvshow_id')->references('id')->on('tvshows')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('genre', ['Action','Adventure','Animation','Biography','Comedy','Crime','Documentary','Drama','Family','Fantasy','Game Show','History','Horror','Music','Musical','Mystery','News','Reality-TV','Romance','Sci-Fi','Sport','Superhero','Talk Show','Thriller','War','Western']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tgenres');
    }
}
