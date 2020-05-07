<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreatorTvshowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creator_tvshow', function (Blueprint $table) {
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('creators')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tvshow_id');
            $table->foreign('tvshow_id')->references('id')->on('tvshows')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('creator_tvshow');
    }
}
