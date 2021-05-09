<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRoleActionManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('role_action_mapping')->truncate();
        Schema::table('role_action_mapping', function (Blueprint $table) {
             $table->integer('hospital_id')->nullable(true)->default(0);
             $table->integer('user_id')->nullable(false);
        });
        
        $mappingData = [
            ['role_id' => 1, 'user_id' => 1, 'menu_id' => 1, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 1, 'menu_id' => 2, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 1, 'menu_id' => 3, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 1, 'menu_id' => 4, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 1, 'menu_id' => 5, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 1, 'menu_id' => 6, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 1, 'menu_id' => 7, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 1, 'menu_id' => 8, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 1, 'menu_id' => 9, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 2, 'menu_id' => 1, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 2, 'menu_id' => 2, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 2, 'menu_id' => 3, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 2, 'menu_id' => 4, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 2, 'menu_id' => 5, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 2, 'menu_id' => 6, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 2, 'menu_id' => 7, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 2, 'menu_id' => 8, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'user_id' => 2, 'menu_id' => 9, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1]
        ];
        DB::table('role_action_mapping')->insert($mappingData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('site_management');
    }
}
