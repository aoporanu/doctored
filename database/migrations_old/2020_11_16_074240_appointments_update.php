<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppointmentsUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('appointments')) {
            if (!Schema::hasColumn('appointments', 'patient_id'))
            {
                Schema::table('appointments', function (Blueprint $table) {
                    $table->string('patient_id')->default(0);
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
//        Schema::table('appointments', function (Blueprint $table) {
//            //
//        });
    }
}
