<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('patients')) {
		  Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('patientcode');
            $table->string('title');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('gender');
            $table->string('dob');
            $table->string('photo')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('password', 300);
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('address_line3')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_country')->nullable();
            $table->string('address_postcode')->nullable();
			 $table->string('address_place')->nullable();
           
            $table->string('address_lat')->nullable();
            $table->string('address_long')->nullable();
            $table->string('last_screening')->nullable();
            $table->string('last_screening_date')->nullable();
            $table->string('emer_firstname')->nullable();
            $table->string('emer_lastname')->nullable();
            $table->string('emer_phone')->nullable();
            $table->string('emer_email')->nullable();
            $table->string('terms')->nullable();
            $table->string('visitor')->nullable();
			$table->string('remember_token')->nullable();
			$table->integer('is_delete')->default(0);
			
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
       // Schema::dropIfExists('patients');
    }
}
