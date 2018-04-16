<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFileFieldsToImagesTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('images', function(Blueprint $table) {     
            
            $table->string('file_file_name')->nullable();
            $table->integer('file_file_size')->nullable();
            $table->string('file_content_type')->nullable();
            $table->timestamp('file_updated_at')->nullable();

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function(Blueprint $table) {

            $table->dropColumn('file_file_name');
            $table->dropColumn('file_file_size');
            $table->dropColumn('file_content_type');
            $table->dropColumn('file_updated_at');

        });
    }

}
