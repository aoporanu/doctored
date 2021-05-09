<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::table('doctors', function (Blueprint $table) {
						  $table->renameColumn('address_address', 'address_lat');
            $table->string('address_place')->nullable();
        });
		Schema::table('group', function (Blueprint $table) {
						 
            $table->string('address_place')->nullable();
			$table->string('address_long')->nullable();
			$table->string('address_lat')->nullable();
        });
		Schema::table('hospitals', function (Blueprint $table) {
					 
            $table->string('address_place')->nullable();
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
