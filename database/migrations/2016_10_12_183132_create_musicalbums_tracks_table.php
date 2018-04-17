<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMusicalbumsTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('musicalbums_tracks', function(Blueprint $table)
		{
			$table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');

            $table->integer('musicalbum_id')->unsigned();
            $table->foreign('musicalbum_id')
                    ->references('id')->on('musicalbums')
                    ->onDelete('cascade');

            $table->string('title');
            $table->mediumText('description');
            $table->string('author');
            $table->string('feat')->nullable();
            $table->string('slug')->nullable();

            $table->boolean('downloadable');

            $table->integer('position');

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
        Schema::drop('musicalbums_tracks');
    }
}
