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
		 if (!Schema::hasTable('hospitals')) {
        Schema::create('hospitals', function (Blueprint $table) {
              $table->bigIncrements('hospital_id');
            $table->string('hospital_name');
			$table->string('hospitalcode')->nullable();
            $table->string('hospital_business_name')->nullable();
            $table->string('hospital_type')->nullable();
            $table->string('dateofregistration')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique();
			$table->string('fax')->nullable();
            $table->string('licence')->unique();
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('address_line3')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_country')->nullable();
            $table->string('address_postcode')->nullable();
			$table->string('location')->nullable();
			 $table->string('address_place')->nullable();
			 $table->string('address_lat')->nullable();
            $table->string('address_long')->nullable();
            $table->longText('summary')->nullable();
            $table->integer('is_active')->default(0);
            $table->integer('is_verified')->default(0);
            $table->integer('is_delete')->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
		 }
		  if (!Schema::hasTable('user_hospital_mapping')) {
		 
		   Schema::create('user_hospital_mapping', function (Blueprint $table) {
            $table->bigIncrements('user_hospital_mapping_id');
            $table->integer('user_id');
            $table->integer('hospital_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
		  }
         if (!Schema::hasTable('group_hospital_mapping')) {
        Schema::create('group_hospital_mapping', function (Blueprint $table) {
            $table->bigIncrements('group_hospital_mapping_id');
            $table->integer('group_id');
            $table->integer('hospital_id');
            $table->integer('created_by');
            $table->integer('updated_by');
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
       // Schema::dropIfExists('hospitals');
		// Schema::dropIfExists('group_hospital_mapping');
		// Schema::dropIfExists('user_hospital_mapping_id');
    }
}
