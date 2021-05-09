<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_role_mapping')) {
            Schema::create('user_role_mapping', function (Blueprint $table) {
                $table->bigIncrements('user_role_mapping_id');
                $table->integer('user_id')->nullable(false);
                $table->integer('role_id')->nullable(false);
                $table->integer('is_lock')->default(0);
                $table->integer('is_delete')->default(0);
                $table->integer('created_by')->default(0);
                $table->integer('updated_by')->default(0);
                $table->timestamps();
            });
            $mappingData = [['user_id' => 1, 'role_id' => 1, 'created_by' => 1, 'is_lock' => 1],
                ['user_id' => 2, 'role_id' => 1, 'created_by' => 1, 'is_lock' => 1],
                ['user_id' => 3, 'role_id' => 1, 'created_by' => 1, 'is_lock' => 1]];
            DB::table('user_role_mapping')->insert($mappingData);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role_mapping');
    }
}
