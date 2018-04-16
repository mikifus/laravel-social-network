<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlbumIdToImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->integer('imagealbum_id')->unsigned()->nullable();
            $table->foreign('imagealbum_id')
                    ->references('id')->on('imagealbums')
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
        Schema::table('images', function (Blueprint $table) {
            $table->dropForeign('images_imagealbum_id_foreign');
            $table->dropColumn('imagealbum_id');
        });
    }
}
