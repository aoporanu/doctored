<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          if (!Schema::hasTable('group')) {
            Schema::create('group', function (Blueprint $table) {
                
			$table->bigIncrements('group_id');
            $table->integer('gid')->from(100000);
            $table->string('group_name');
			$table->string('logo')->nullable();
			$table->string('banner')->nullable();
			$table->longText('group_description')->nullable();
			$table->string('group_business_name')->nullable();
			$table->string('address')->nullable();
			$table->string('address_place')->nullable();
			$table->string('address_long')->nullable();
			$table->string('address_lat')->nullable();	
			$table->string('phone')->nullable();
            $table->string('email')->nullable();
			$table->string('licence')->nullable();
			$table->integer('pay_slab')->default(90);
				//common 
			$table->integer('is_active')->default(1);
            $table->integer('is_lock')->default(0);
            $table->integer('is_delete')->default(0);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
            });
            
            
           
        }
		 if (!Schema::hasTable('group_user_mapping')) {
		  Schema::create('group_user_mapping', function (Blueprint $table) {
            $table->bigIncrements('group_user_mapping_id');
            $table->integer('gid');
            $table->integer('user_id');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
		}
		
		 if (!Schema::hasTable('group_role_mapping')) {
		    Schema::create('group_role_mapping',function (Blueprint $table){
            $table->bigIncrements('group_role_mapping_id');
            $table->integer('gid');
            $table->integer('role_id');
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
            //
		//	 Schema::dropIfExists('group');
       // Schema::dropIfExists('group_user_mapping');
     //   Schema::dropIfExists('group_role_mapping');
     
    }
}
