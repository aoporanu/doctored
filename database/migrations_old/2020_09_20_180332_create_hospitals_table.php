<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->bigIncrements('hospital_id');
            $table->string('hospital_name');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
        
        Schema::create('user_hospital_mapping', function (Blueprint $table) {
            $table->bigIncrements('user_hospital_mapping_id');
            $table->integer('user_id');
            $table->integer('hospital_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
        
        Schema::create('group_hospital_mapping', function (Blueprint $table) {
            $table->bigIncrements('group_hospital_mapping_id');
            $table->integer('group_id');
            $table->integer('hospital_id');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('hospitals');
        Schema::dropIfExists('user_hospital_mapping');
        Schema::dropIfExists('group_hospital_mapping');
    }
}
