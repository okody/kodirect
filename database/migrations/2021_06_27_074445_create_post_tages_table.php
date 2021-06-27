<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tages', function (Blueprint $table) {
            $table->increments("id");
            $table->index('TageID');
            $table->foreign('TageID')->references('id')->on('tages')->onDelete('cascade');
            $table->index('PostID');
            $table->foreign('PostID')->references('id')->on('posts')->onDelete('cascade');
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
        Schema::dropIfExists('post_tages');
        
    }
}
