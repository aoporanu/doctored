<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleActionMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('roles')) {
            if (!Schema::hasTable('role_action_mapping')) {
                Schema::create('role_action_mapping', function (Blueprint $table) {
                    $table->bigIncrements('role_action_mapping_id');
                    $table->integer('role_id')->nullable();
                    $table->integer('user_id')->nullable();
                    $table->integer('hospital_id')->nullable();
                    $table->integer('menu_id')->nullable(false);
                    $table->boolean('create_access')->default(false);
                    $table->boolean('edit_access')->default(false);
                    $table->boolean('view_access')->default(false);
                    $table->boolean('delete_access')->default(false);
                    $table->enum('limited_to', array('All', 'Own'));
                    $table->integer('is_lock')->default(0);
                    $table->integer('is_delete')->default(0);
                    $table->integer('created_by')->default(0);
                    $table->integer('updated_by')->default(0);
                    $table->timestamps();
                });
                $mappingData = [
                    ['role_id' => 1, 'menu_id' => 1, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 2, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 3, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 4, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 5, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 6, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 7, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 8, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 9, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 10, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 11, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 12, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 13, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 14, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 15, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 16, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 17, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 18, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 19, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 1, 'menu_id' => 20, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 2, 'menu_id' => 4, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 2, 'menu_id' => 6, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 2, 'menu_id' => 8, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 2, 'menu_id' => 9, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 2, 'menu_id' => 10, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 2, 'menu_id' => 12, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1],
                    ['role_id' => 2, 'menu_id' => 15, 'create_access' => true, 'edit_access' => true, 'view_access' => true, 'delete_access' => true, 'limited_to' => 'All', 'created_by' => 1, 'is_lock' => 1]
                ];
                DB::table('role_action_mapping')->insert($mappingData);
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
        Schema::dropIfExists('role_action_mapping');
    }
}
