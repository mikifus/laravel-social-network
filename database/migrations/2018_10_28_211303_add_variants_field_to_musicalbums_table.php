<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVariantsFieldToMusicalbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musicalbums', function(Blueprint $table) {

            $table->string('front_variants', 255)->nullable();
            $table->string('back_variants', 255)->nullable();

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

            $table->dropColumn('front_variants');
            $table->dropColumn('back_variants');

        });
    }
}
