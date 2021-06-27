<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments("id");
            $table->string("title");
            $table->mediumText("url");
            $table->mediumText("Content");
            $table->string("Type");
            $table->integer('useri_id');
            $table->foreign('useri_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('notifications',  function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropIndex('user_id');
        });
    }
}
