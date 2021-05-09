<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MetatypesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('metatype_data')) {
            Schema::create('metatype_data', function (Blueprint $table) {
                $table->bigIncrements('metatype_data_id');
                $table->string('mapping_type');
                $table->integer('mapping_type_id');
                $table->integer('mapping_type_data_id');
                $table->string('mapping_type_data_value');
                $table->integer('is_active')->default(1);
                $table->integer('created_by')->default(0);
                $table->integer('updated_by')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metatype_data');
    }
}
