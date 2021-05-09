<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIsDeleteAll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		 Schema::table('group', function (Blueprint $table) {
            $table->integer('is_delete')->default(0)->change();
        });
		 Schema::table('pages', function (Blueprint $table) {
            $table->integer('is_delete')->default(0)->change();
        });
		 Schema::table('page_elements', function (Blueprint $table) {
            $table->integer('is_delete')->default(0)->change();
        });
		Schema::table('roles', function (Blueprint $table) {
            $table->integer('is_delete')->default(0)->change();
        });
		Schema::table('hospitals', function (Blueprint $table) {
            $table->integer('is_delete')->default(0)->change();
        });
		
		Schema::table('users', function (Blueprint $table) {
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
