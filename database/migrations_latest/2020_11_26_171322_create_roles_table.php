<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->bigIncrements('role_id');
                $table->string('role_name')->nullable(false);
                $table->integer('is_active')->default(1);
                $table->integer('is_lock')->default(0);
                $table->integer('is_delete')->default(0);
                $table->integer('created_by')->default(0);
                $table->integer('updated_by')->default(0);
                $table->timestamps();
            });
            $data = [
                ['role_name' => 'Super Admin', 'created_by' => 1, 'is_lock' => 1],
                ['role_name' => 'Site Admin', 'created_by' => 1, 'is_lock' => 1]
            ];
            DB::table('roles')->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
