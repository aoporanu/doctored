<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletePatientsAndSpecializationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('patients', function (Blueprint $table) {
            $table->integer('is_delete')->default(0);
        });
		
		Schema::table('specialization_types', function (Blueprint $table) {
            $table->integer('is_delete')->default(0);
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
