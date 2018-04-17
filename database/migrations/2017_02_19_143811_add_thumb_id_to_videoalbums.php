<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThumbIdToVideoalbums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videoalbums', function(Blueprint $table) {
            $table->integer('thumb_id')->unsigned()->nullable();
            $table->foreign('thumb_id')
                    ->references('id')->on('videos')
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
        Schema::table('videoalbums', function (Blueprint $table) {
            $table->dropForeign('videoalbums_thumb_id_foreign');
            $table->dropColumn('thumb_id');
        });
    }
}
