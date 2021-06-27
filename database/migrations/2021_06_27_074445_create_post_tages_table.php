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
            $table->index('tage_id');
            $table->foreign('tage_id')->references('id')->on('tages')->onDelete('cascade');
            $table->index('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
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
        Schema::dropIfExists('post_tages' , function(Blueprint $table) {
            $table->dropForeign('tage_id');
            $table->dropIndex('tage_id');
            $table->dropForeign('post_id');
            $table->dropIndex('post_id');
        });
        
    }
}
