<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToHospitalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         

        Schema::table('hospitals', function (Blueprint $table) {
           
            
            
            $table->string('hospitalcode')->nullable();
            $table->string('hospital_business_name')->nullable();
            $table->string('hospital_type')->nullable();
            $table->string('dateofregistration')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('fax')->unique();
            $table->string('licence')->unique();
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('address_line3')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_country')->nullable();
            $table->string('address_postcode')->nullable();
            $table->string('address_lat')->nullable();
            $table->string('address_long')->nullable();
            $table->string('summary')->nullable();
            $table->integer('is_active')->default(0);
            $table->integer('is_verified')->default(0);
          
//            $table->timestamps();
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            //
             
           
        });
    }
}
