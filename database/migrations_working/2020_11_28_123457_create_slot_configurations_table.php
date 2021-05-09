<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		  if (!Schema::hasTable('slot_configurations')) {
        Schema::create('slot_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->string('screen_id')->nullable();;
			$table->integer('doctor_id')->nullable();
			$table->integer('hospital_id')->nullable();
			$table->string('conf_key',300)->nullable();
			$table->longText('conf_value')->nullable();
			$table->string('iteration')->default(1);
			
			$table->integer('is_active')->default(1);
            $table->integer('is_lock')->default(0);
            $table->integer('is_delete')->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
					 
			 $table->timestamps();
			 
        });
		  }
		  if (!Schema::hasTable('slots')) { 
		   Schema::create('slots', function (Blueprint $table) {
            //
			 $table->bigIncrements('id');
			  $table->string('screen_id')->nullable();
			 $table->integer('doctor_id')->nullable();
			 $table->integer('hospital_id')->nullable();
			 $table->string('booking_date')->nullable();
			 $table->string('booking_start_time')->nullable(); //24 hours
			 $table->string('booking_time_long')->nullable();
			$table->string('available_types')->nullable();
			$table->string('is_active')->default(1);
			$table->integer('is_lock')->default(0);
            $table->integer('is_delete')->default(0);
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
      //  Schema::dropIfExists('slot_configurations');
		// Schema::dropIfExists('slots');
    }
}
