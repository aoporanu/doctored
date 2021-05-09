<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorMetatypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_metatypes', function (Blueprint $table) {
            $table->bigIncrements('dmeta_id');
			$table->string('dmetaname');
			$table->string('dmetakey');
			$table->string('dmeta_lang_code')->nullable();
			$table->string('dmeta_icon')->nullable();
			$table->integer('is_delete')->default(0)->nullable();
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
        Schema::dropIfExists('doctor_metatypes');
    }
}
