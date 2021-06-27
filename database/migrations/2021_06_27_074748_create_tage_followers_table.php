<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTageFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tage_followers', function (Blueprint $table) {
            $table->increments("id");
            $table->index('TageID');
            $table->foreign('TageID')->references('id')->on('tages')->onDelete('cascade');
            $table->index('UserID');
            $table->foreign('UserID')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('tage_followers');
    }
}
