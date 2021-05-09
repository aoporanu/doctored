<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('api_configuration')) {
			Schema::create('api_configuration', function (Blueprint $table) {
			 $table->bigIncrements('id');
                            $table->string('request_type');
                            $table->string('environment');
                            $table->string('api_type');
                            $table->string('api_url')->nullable();;
                            $table->string('api_key')->nullable();;
                            $table->string('api_token')->nullable();;
                            $table->string('username')->nullable();;
                            $table->string('password')->nullable();;
                            $table->string('param1_key')->nullable();
                            $table->string('param1_value')->nullable();
                            $table->string('param2_key')->nullable();
                            $table->string('param2_value')->nullable();
                           
                            $table->integer('is_delete')->default(0);
                            $table->integer('is_active')->default(1);
							  $table->integer('is_lock')->default(0);
							 $table->integer('created')->default(0);
                            $table->integer('updated')->default(0);
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
      //  Schema::dropIfExists('api_configuration');
    }
}
