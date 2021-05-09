<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddRememberToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		 Schema::table('doctors', function($table) {
       $table->rememberToken();
    });
		 Schema::table('patients', function($table) {
       $table->rememberToken();
    });
		 Schema::table('users', function($table) {
       $table->rememberToken();
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
