<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments("id");
            $table->mediumText("imageUrl");
            $table->string("format");
            $table->tinyText("title");
            $table->mediumText("comment")->nullable();
            $table->boolean("hidden")->default(false);
            $table->foreignId('user_id')->constrained()->onDelete("set null");
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
        Schema::dropIfExists('posts', function (Blueprint $table) {
        });
    }
}
