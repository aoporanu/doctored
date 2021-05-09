<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('consultation_data')) {
            Schema::create('consultation_data', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('doctor_id');
                $table->integer('patient_id');
                $table->string('consultation_type');
                $table->string('consultation_type_data');
                $table->integer('is_delete')->default(0);
                $table->integer('is_active')->default(1);
                $table->integer('is_lock')->default(0);
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
        Schema::dropIfExists('consultation_data');
    }
}
