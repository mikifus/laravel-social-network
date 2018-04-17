<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class Videoalbums.
 *
 * @author  The scaffold-interface created at 2017-02-18 11:47:16pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class CreateVideoalbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('videoalbums',function (Blueprint $table){

        $table->increments('id');

        $table->String('name');

        $table->String('description');

        /**
         * Foreignkeys section
         */


        $table->timestamps();


        // type your addition here

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('videoalbums');
    }
}
