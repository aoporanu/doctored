<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentAlternateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		 Schema::dropIfExists('appointments');
         if (!Schema::hasTable('appointments')) {
       

        Schema::create('appointments', function (Blueprint $table) {
			 $table->bigIncrements('id');
			 $table->string('booking_id')->nullable();
			 $table->integer('doctor_id')->nullable();
			 $table->integer('patient_id')->nullable();
			  
			    $table->integer('hospital_id')->nullable();
			 $table->string('booking_date')->nullable();
			 $table->string('booking_start_time')->nullable(); //24 hours
			 $table->string('booking_time_long')->nullable();
			 $table->string('booking_type')->nullable();
			 $table->string('screen_id')->nullable();
			 $table->string('slotid')->nullable();
			  $table->string('title')->nullable(); 
			    $table->string('description')->nullable(); 
				 $table->string('email')->nullable(); 
				  $table->string('phone')->nullable(); 
			 $table->string('doctor_concent')->nullable();   
			$table->string('patien_concent')->nullable();
			$table->string('payment_status')->nullable();
			$table->string('booking_status')->nullable();	
			$table->string('appointment_status')->nullable();	
			$table->string('booking_from_country')->nullable();	
			$table->string('booking_timezone')->nullable();
			$table->string('booking_sysip')->nullable();			
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
        Schema::dropIfExists('appointment_alternate');
    }
}
