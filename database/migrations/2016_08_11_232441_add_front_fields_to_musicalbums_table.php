<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFrontFieldsToMusicalbumsTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musicalbums', function(Blueprint $table) {

            $table->string('front_file_name')->nullable();
            $table->integer('front_file_size')->nullable()->after('front_file_name');
            $table->string('front_content_type')->nullable()->after('front_file_size');
            $table->timestamp('front_updated_at')->nullable()->after('front_content_type');

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('musicalbums', function(Blueprint $table) {

            $table->dropColumn('front_file_name');
            $table->dropColumn('front_file_size');
            $table->dropColumn('front_content_type');
            $table->dropColumn('front_updated_at');

        });
    }

}