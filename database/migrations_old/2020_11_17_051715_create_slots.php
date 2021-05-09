<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slots', function (Blueprint $table) {
            //
			 $table->bigIncrements('id');
			 $table->integer('doctor_id')->nullable();
			 $table->integer('hospital_id')->nullable();
			 $table->string('booking_date')->nullable();
			 $table->string('booking_start_time')->nullable(); //24 hours
			 $table->string('booking_time_long')->nullable();
			$table->string('available_types')->nullable();
			$table->string('is_active')->default(1);
			 $table->string('screen_id')->nullable();;
			 
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
        Schema::table('slots', function (Blueprint $table) {
            //
        });
    }
}
