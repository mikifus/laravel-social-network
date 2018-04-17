<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBackFieldsToMusicalbumsTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musicalbums', function(Blueprint $table) {

            $table->string('back_file_name')->nullable();
            $table->integer('back_file_size')->nullable()->after('back_file_name');
            $table->string('back_content_type')->nullable()->after('back_file_size');
            $table->timestamp('back_updated_at')->nullable()->after('back_content_type');

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

            $table->dropColumn('back_file_name');
            $table->dropColumn('back_file_size');
            $table->dropColumn('back_content_type');
            $table->dropColumn('back_updated_at');

        });
    }

}