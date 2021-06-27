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
            $table->integer('tage_id');
            $table->foreign('tage_id')->references('id')->on('tages')->onDelete('cascade');
            $table->integer('user_id');
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
        Schema::dropIfExists('tage_followers',  function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropIndex('user_id');
            $table->dropForeign('tage_id');
            $table->dropIndex('tage_id');
        });
    }
}
