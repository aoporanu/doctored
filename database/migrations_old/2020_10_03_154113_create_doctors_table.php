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
            $table->integer('is_verified')->default(0);
            $table->integer('is_active')->default(0);
            $table->integer('is_delete')->default(0);
            $table->string('password', 300);
            $table->string('terms')->nullable();
            $table->string('gender')->nullable();
            $table->string('dob')->nullable();
            $table->string('photo')->nullable();
            $table->string('summary')->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('address_line3')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_country')->nullable();
            $table->string('address_postcode')->nullable();
            $table->string('address_address')->nullable();
            $table->string('address_long')->nullable();
            $table->string('activation_key')->nullable();
      
            $table->string('visitor')->nullable();
           
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
        Schema::dropIfExists('doctors');
    }
}
