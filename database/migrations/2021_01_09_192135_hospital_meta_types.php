<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HospitalMetaTypes extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('hospital_metatypes')) {
            Schema::create('hospital_metatypes', function (Blueprint $table) {
                $table->bigIncrements('hmeta_id');
                $table->string('hmetaname');
                $table->string('hmetakey');
                $table->string('hmeta_lang_code')->nullable();
                $table->string('hmeta_icon')->nullable();
                $table->integer('is_active')->default(1);
                $table->integer('is_lock')->default(0);
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
    public function down() {
        //
    }

}
