<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('doctors_metatypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type_icon')->nullable();
            $table->string('type_name')->nullable();
              $table->timestamps();
        });
        Schema::create('doctors_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('doc_id');
            $table->unsignedBigInteger('doc_mtype_id');
            $table->string('meta_key_type')->nullable();
            $table->string('meta_key_name')->nullable();
            $table->string('meta_key_value')->nullable();
            $table->foreign('doc_id')->references('id')->on('doctors');
            $table->foreign('doc_mtype_id')->references('id')->on('doctors_metatypes');
            
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
        Schema::dropIfExists('doctors_metatypes');
        Schema::dropIfExists('doctors_meta');
    }
}
