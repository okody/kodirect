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
        Schema::create('user_tage', function (Blueprint $table) {
            $table->increments("id");
            $table->foreignId('tage_id')->constrained();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('user_tage',  function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropIndex('user_id');
            $table->dropForeign('tage_id');
            $table->dropIndex('tage_id');
        });
    }
}
