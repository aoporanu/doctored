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
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('user_id');
                $table->string('user_name')->nullable();
                $table->string('email')->nullable(false);
                $table->string('password')->nullable(false);
                $table->integer('is_superadmin')->default(0);
                $table->string('photo')->nullable();
                $table->string('gender')->nullable();
                $table->string('dob')->nullable();
                $table->string('remember_token')->nullable();
                $table->datetime('last_login_at')->nullable();
                $table->string('last_login_ip')->nullable();
                $table->integer('is_active')->default(1);
                $table->integer('is_lock')->default(0);
                $table->integer('is_delete')->default(0);
                $table->integer('created_by')->default(0);
                $table->integer('updated_by')->default(0);
                $table->timestamps();
            });
            
            // Insert some stuff
            $data = [
                ['user_name' => 'Superadmin', 'email' => 'sandeep.jeedula@gmail.com', 'password' => hash(env('HASH_CODE'), env('SALT').'Sandeep1@234'), 'is_superadmin' => 1, 'created_by' => 1, 'is_lock' => 1],
                ['user_name' => 'Superadmin', 'email' => 'naresh22sep@gmail.com', 'password' => hash(env('HASH_CODE'), env('SALT').'Naresh1@234'), 'is_superadmin' => 1, 'created_by' => 1, 'is_lock' => 1],
                ['user_name' => 'Superadmin', 'email' => 'admin@doctored.com', 'password' => hash(env('HASH_CODE'), env('SALT').'Admin@2234'), 'is_superadmin' => 1, 'created_by' => 1, 'is_lock' => 1]
            ];
            DB::table('users')->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
