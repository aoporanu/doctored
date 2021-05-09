<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientMetatypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		 if (!Schema::hasTable('patient_metatypes')) {
			Schema::create('patient_metatypes', function (Blueprint $table) {
            $table->bigIncrements('pmeta_id');
			$table->string('pmetaname');
			$table->string('pmetakey');
			$table->string('pmeta_lang_code')->nullable();
			$table->string('pmeta_icon')->nullable();
			$table->integer('is_active')->default(0);
           	$table->integer('is_delete')->default(0)->nullable();
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
     //   Schema::dropIfExists('patient_metatypes');
    }
}
