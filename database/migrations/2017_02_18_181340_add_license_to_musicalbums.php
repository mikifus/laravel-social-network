<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLicenseToMusicalbums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musicalbums', function (Blueprint $table) {
            $table->string('license_type');
            $table->string('license_params');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('musicalbums', function(Blueprint $table) {
            $table->dropColumn('license_type');
            $table->dropColumn('license_params');
        });
    }
}
