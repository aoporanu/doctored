<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLangMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('lang_mapping')) {
            Schema::create('lang_mapping', function (Blueprint $table) {
                $table->smallIncrements('id');
                $table->string('module_mapping_type');
                $table->integer('module_mapping_type_id');
                $table->string('lang_mapping_id');
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
        Schema::dropIfExists('lang_mapping');
    }
}
