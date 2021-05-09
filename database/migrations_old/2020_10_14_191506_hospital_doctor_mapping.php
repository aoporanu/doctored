<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HospitalDoctorMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_doctor_mapping', function (Blueprint $table) {
            $table->bigIncrements('hd_mapping_id');
            $table->integer('hospital_id');
            $table->integer('doctor_id');
            $table->integer('is_delete')->default(0)->nullable();
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
        //
    }
}
