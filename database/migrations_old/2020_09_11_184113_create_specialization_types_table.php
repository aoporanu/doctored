<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecializationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialization_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('specialization_name');
            $table->string('specialization_shortcode')->nullable();
            $table->string('specialization_description')->nullable();
            $table->string('specialization_parent')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialization_types');
    }
}
