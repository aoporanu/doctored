<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('consultation_mapping')) {
            Schema::create('consultation_mapping', function (Blueprint $table) {
                $table->bigIncrements('consultation_mapping_id');
                $table->string('mapping_type');
                $table->integer('mapping_type_id');
                $table->integer('consultation_id');
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
        Schema::dropIfExists('consultation_mapping');
    }
}
