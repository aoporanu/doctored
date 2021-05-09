<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupUserrolemappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group', function (Blueprint $table) {
            $table->bigIncrements('group_id');
            $table->integer('gid')->from(100000);
            $table->string('group_name');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
            $table->unique(['group_id', 'gid']);
        });
        // Insert some stuff
        $data = [
            ['gid' => 100001, 'group_name' => 'Site Admin 1', 'created_by' => 1],
            ['gid' => 100002, 'group_name' => 'Site Admin 2', 'created_by' => 1],
            ['gid' => 100003, 'group_name' => 'Site Admin 3', 'created_by' => 1]
        ];
        DB::table('group')->insert($data);
        
        /////user group mapping table
        Schema::create('group_user_mapping', function (Blueprint $table) {
            $table->bigIncrements('group_user_mapping_id');
            $table->integer('gid');
            $table->integer('user_id');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
        
        // Insert some stuff
        $mappingData = [
            ['gid' => 100001, 'user_id' => 1, 'created_by' => 1],
            ['gid' => 100001, 'user_id' => 2, 'created_by' => 1],
            ['gid' => 100002, 'user_id' => 3, 'created_by' => 1],
            ['gid' => 100003, 'user_id' => 4, 'created_by' => 1]
        ];
        DB::table('group_user_mapping')->insert($mappingData);
        
        Schema::create('group_role_mapping',function (Blueprint $table){
            $table->bigIncrements('group_role_mapping_id');
            $table->integer('gid');
            $table->integer('role_id');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });

        $rolesGroupData = [
            ['role_id' => 2, 'gid' => 100001, 'created_by' => 1],
            ['role_id' => 3, 'gid' => 100003, 'created_by' => 1],
            ['role_id' => 4, 'gid' => 100002, 'created_by' => 1],
            ['role_id' => 5, 'gid' => 100002, 'created_by' => 1],
        ];
        DB::table('group_role_mapping')->insert($rolesGroupData);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group');
        Schema::dropIfExists('group_user_mapping');
        Schema::dropIfExists('group_role_mapping');
    }
}
