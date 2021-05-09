<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
				 if (!Schema::hasTable('appointments')) {
        
        Schema::create('appointments', function (Blueprint $table) {
			 $table->bigIncrements('id');
			 $table->integer('doctor_id')->nullable();
			 $table->string('patient_id')->default(0);
			 $table->integer('hospital_id')->nullable();
			 $table->string('booking_date')->nullable();
			 $table->string('booking_start_time')->nullable(); //24 hours
			 $table->string('booking_time_long')->nullable();
			 $table->timestamps();
            //
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
       // Schema::dropIfExists('appointments');
    }
}
