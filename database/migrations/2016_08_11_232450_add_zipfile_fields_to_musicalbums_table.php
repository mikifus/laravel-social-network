<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddZipfileFieldsToMusicalbumsTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musicalbums', function(Blueprint $table) {

            $table->string('zipfile_file_name')->nullable();
            $table->integer('zipfile_file_size')->nullable()->after('zipfile_file_name');
            $table->string('zipfile_content_type')->nullable()->after('zipfile_file_size');
            $table->timestamp('zipfile_updated_at')->nullable()->after('zipfile_content_type');

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

            $table->dropColumn('zipfile_file_name');
            $table->dropColumn('zipfile_file_size');
            $table->dropColumn('zipfile_content_type');
            $table->dropColumn('zipfile_updated_at');

        });
    }

}