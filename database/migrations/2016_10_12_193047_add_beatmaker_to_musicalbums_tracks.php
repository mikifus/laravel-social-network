<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBeatmakerToMusicalbumsTracks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musicalbums_tracks', function (Blueprint $table) {
            $table->string('beatmaker');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('musicalbums_tracks', function (Blueprint $table) {
            $table->dropColumn('beatmaker');
        });
    }
}
