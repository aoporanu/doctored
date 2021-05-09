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
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('role_id');
            $table->string('role_name');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
                // Insert some stuff
        $data = [
            ['role_name' => 'Superadmin', 'created_by' => 1]
        ];
        DB::table('roles')->insert($data);
        Schema::create('role_action_mapping', function (Blueprint $table) {
            $table->bigIncrements('role_action_mapping_id');
            $table->integer('role_id');
            $table->integer('menu_id');
            $table->boolean('create_access');
            $table->boolean('edit_access');
            $table->boolean('view_access');
            $table->boolean('delete_access');
            $table->enum('limited_to', array('All', 'Own'));
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });

        $mappingData = [
            ['role_id' => 1, 'menu_id' => 1, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'menu_id' => 2, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'menu_id' => 3, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'menu_id' => 4, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'menu_id' => 5, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'menu_id' => 6, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'menu_id' => 7, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'menu_id' => 8, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1],
            ['role_id' => 1, 'menu_id' => 9, 'create_access' => 1, 'edit_access' => 1, 'view_access' => 1, 'delete_access' => 1, 'limited_to' => 'All', 'created_by' => 1]
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
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_action_mapping');
    }
}
