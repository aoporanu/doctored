<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsMetatypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (!Schema::hasTable('doctor_metatypes')) { 
        Schema::create('doctor_metatypes', function (Blueprint $table) {
           $table->bigIncrements('dmeta_id');
			$table->string('dmetaname');
			$table->string('dmetakey');
			$table->string('dmeta_lang_code')->nullable();
			$table->string('dmeta_icon')->nullable();
			$table->integer('is_active')->default(1);
			$table->integer('is_lock')->default(0);
			$table->integer('is_delete')->default(0)->nullable();
            $table->timestamps();
        });
	   }
	   if (!Schema::hasTable('doctors_meta')) {
        Schema::create('doctors_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('doc_id');
            $table->unsignedBigInteger('doc_mtype_id');
            $table->string('meta_key_type')->nullable();
            $table->string('meta_key_name')->nullable();
            $table->string('meta_key_value')->nullable();
            $table->foreign('doc_id')->references('id')->on('doctors');
            $table->foreign('doc_mtype_id')->references('dmeta_id')->on('doctor_metatypes');
            
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
        //Schema::dropIfExists('doctors_metatypes');
    }
}
