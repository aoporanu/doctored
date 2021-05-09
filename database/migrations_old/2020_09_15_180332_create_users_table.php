<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('user_name');
            $table->string('email');
            $table->string('password');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('is_superadmin')->default(0);
            $table->timestamps();
        });
        // Insert some stuff
        $data = [
            ['user_name' => 'Superadmin', 'email' => 'sandeep.jeedula@gmail.com', 'password' => 'sandeep@1234', 'is_superadmin' => 1, 'created_by' => 1],
            ['user_name' => 'Superadmin', 'email' => 'naresh22sep@gmail.com', 'password' => 'naresh@1234', 'is_superadmin' => 1, 'created_by' => 1],
            ['user_name' => 'Superadmin', 'email' => 'narender@gmail.com', 'password' => 'narender@1234', 'is_superadmin' => 1, 'created_by' => 1]
        ];
        DB::table('users')->insert($data);
        
        Schema::create('user_role_mapping', function (Blueprint $table) {
            $table->bigIncrements('user_role_mapping_id');
            $table->integer('user_id');
            $table->integer('role_id');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });

        $mappingData = [['user_id' => 1, 'role_id' => 1, 'created_by' => 1],
            ['user_id' => 2, 'role_id' => 1, 'created_by' => 1]];
        DB::table('user_role_mapping')->insert($mappingData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_role_mapping');
    }
}
