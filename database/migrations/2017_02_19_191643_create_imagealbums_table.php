<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagealbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagealbums', function (Blueprint $table) {
            $table->increments('id');
            $table->String('title');
            $table->String('description');

            /**
             * Foreignkeys section
             */
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');

            $table->integer('thumb_id')->unsigned()->nullable();
            $table->foreign('thumb_id')
                    ->references('id')->on('images')
                    ->onDelete('set null');


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
//        Schema::table('imagealbums', function (Blueprint $table) {
//            $table->dropForeign('imagealbums_user_id_foreign');
//            $table->dropForeign('imagealbums_thumb_id_foreign');
//            $table->dropColumn('user_id');
//            $table->dropColumn('thumb_id');
//        });
        Schema::drop('imagealbums');
    }
}
