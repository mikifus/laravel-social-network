<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVideoalbumIdToVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->integer('videoalbum_id')->unsigned()->nullable();
            $table->foreign('videoalbum_id')
                    ->references('id')->on('videoalbums')
                    ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign('videos_videoalbum_id_foreign');
            $table->dropColumn('videoalbum_id');
        });
    }
}
