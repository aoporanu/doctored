<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConsultationData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('consultation_data')) {
            if (!Schema::hasColumn('consultation_data', 'hospital_id')) {
                Schema::table('consultation_data', function (Blueprint $table) {
                    $table->integer('hospital_id')->nullable(false);
                    $table->integer('slot_id')->nullable();
                    $table->text('consultation_type_data')->change();
                });
            }
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
