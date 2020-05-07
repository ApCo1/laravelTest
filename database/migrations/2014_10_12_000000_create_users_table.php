<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('level', ['user', 'admin','editor','ultraadmin'])->defaulet('user');
            $table->string('metaphone',200);
            $table->integer('movie_reviews')->default('0');
            $table->integer('tvshow_reviews')->default('0');
            $table->decimal('average_mreviews',3,1)->default('0');
            $table->decimal('average_treviews',3,1)->default('0');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
