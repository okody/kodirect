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
            $table->mediumText("content");
            $table->string("Type");
            $table->foreignId('useri_id')->constrained();
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
