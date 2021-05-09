<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		 if (!Schema::hasTable('contacts')) {
         Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->string('sirname')->nullable();
            $table->string('clinicname')->nullable();
            $table->string('email');
            $table->string('phone');
			$table->integer('is_check')->default(0);
            $table->string('description')->nullable();
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
      //  Schema::dropIfExists('contacts');
    }
}
