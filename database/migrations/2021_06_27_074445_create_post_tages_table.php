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
        Schema::create('post_tage', function (Blueprint $table) {
            $table->increments("id");
            $table->foreignId('tage_id')->constrained();
            $table->foreignId('post_id')->constrained();
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
        Schema::dropIfExists('post_tages', function (Blueprint $table) {
            $table->dropForeign('tage_id');
            $table->dropIndex('tage_id');
            $table->dropForeign('post_id');
            $table->dropIndex('post_id');
        });
    }
}
