<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group', function (Blueprint $table) {
            $table->string('logo')->nullable();
			$table->string('banner')->nullable();
			$table->string('group_description')->nullable();
			$table->string('group_business_name')->nullable();
			$table->string('address')->nullable();
			$table->string('phone')->nullable();
            $table->string('email')->nullable();
			$table->string('licence')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group', function (Blueprint $table) {
            //
        });
    }
}
