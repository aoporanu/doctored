<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SlotConfigurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('slot_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->string('screen_id')->nullable();;

			$table->integer('doctor_id')->nullable();
			$table->integer('hospital_id')->nullable();
			$table->string('conf_key',300)->nullable();
			$table->longText('conf_value')->nullable();
						    $table->string('iteration')->default(1);
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
        //
    }
}
