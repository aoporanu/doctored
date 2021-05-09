<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		 if (!Schema::hasTable('doctors')) {
        Schema::create('doctors', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->string('doctorcode');
            $table->string('title');
            $table->string('firstname');
            $table->string('lastname');
        
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('licence')->unique();
            $table->string('opt_clinic');
             $table->string('password', 300);
            $table->string('terms')->nullable();
            $table->string('gender')->nullable();
            $table->string('dob')->nullable();
            $table->string('photo')->nullable();
            $table->longText('summary')->nullable();
			
			$table->integer('duration')->default(15);
			$table->integer('pay_slab')->default(70);
			
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('address_line3')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_country')->nullable();
            $table->string('address_postcode')->nullable();
			
			
			 $table->string('address_place')->nullable();
            $table->string('address_lat')->nullable();
            $table->string('address_long')->nullable();
           
            $table->string('visitor')->nullable();
			$table->string('verification_summary')->nullable();
            $table->integer('is_verified')->default(0);
			 $table->integer('is_rejected')->default(0);
            $table->integer('verified_user')->default(0);
			
			 $table->string('activation_key')->nullable();
			$table->string('remember_token')->nullable();
      
			$table->integer('is_restricted')->default(0);
            $table->integer('restricted_gid')->default(0);
			
			$table->integer('is_active')->default(0);
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
      //  Schema::dropIfExists('doctors');
    }
}
