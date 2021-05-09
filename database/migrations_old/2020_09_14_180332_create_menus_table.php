<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('menu_id');
            $table->string('menu_name');
            $table->string('menu_description');
            $table->string('parent_id');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
        // Insert some stuff
       /* $data = [
            ['menu_name' => 'Dashboard','parent_id' => 0,'menu_description' => 'Dasboard Menu', 'created_by' => 1],
            ['menu_name' => 'Groups','parent_id' => 0,'menu_description' => 'Groups Menu', 'created_by' => 1],
            ['menu_name' => 'Roles','parent_id' => 0,'menu_description' => 'Roles Menu', 'created_by' => 1],
            ['menu_name' => 'Users','parent_id' => 0,'menu_description' => 'Users Menu', 'created_by' => 1],
            ['menu_name' => 'Menus','parent_id' => 0,'menu_description' => 'Menus', 'created_by' => 1],
            ['menu_name' => 'Hospitals','parent_id' => 0,'menu_description' => 'Hospitals Menu', 'created_by' => 1],
            ['menu_name' => 'Billing','parent_id' => 0,'menu_description' => 'Billing Menu', 'created_by' => 1],
            ['menu_name' => 'Schedule Management','parent_id' => 0,'menu_description' => 'Schedule Management', 'created_by' => 1],
            ['menu_name' => 'Slot Management','parent_id' => 0,'menu_description' => 'Slot Management', 'created_by' => 1]
        ];
        DB::table('menus')->insert($data);*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
