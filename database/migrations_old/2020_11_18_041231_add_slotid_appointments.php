<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlotidAppointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('appointments')) {
            if (!Schema::hasColumn('appointments', 'slot_id'))
            {
                Schema::table('appointments', function (Blueprint $table) {
                    $table->string('slot_id')->default(0);
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
        Schema::table('appointments', function (Blueprint $table) {
            //
        });
    }
}
