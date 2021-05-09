<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusUpdateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->string('menu_url')->after('menu_description')->nullable();
            $table->integer('sort_order')->after('menu_url')->nullable();
            $table->string('menu_icon')->after('sort_order')->default('md-view-dashboard');
        });
//        DB::table('menus')->truncate();
//        // Insert some stuff
        $data = [
            ['menu_url' => '/admin/dashboard', 'sort_order' => 1, 'updated_by' => 1],
            ['menu_url' => '/admin/groups', 'sort_order' => 2, 'updated_by' => 1],
            ['menu_url' => '/admin/roles', 'sort_order' => 3, 'updated_by' => 1],
            ['menu_url' => '/admin/users', 'sort_order' => 4, 'updated_by' => 1],
            ['menu_url' => '/admin/menus', 'sort_order' => 5, 'updated_by' => 1],
            ['menu_url' => '/admin/hospitals', 'sort_order' => 6, 'updated_by' => 1],
            ['menu_url' => '/admin/billing', 'sort_order' => 7, 'updated_by' => 1],
            ['menu_url' => '/admin/schedule', 'sort_order' => 8, 'updated_by' => 1],
            ['menu_url' => '/admin/slots', 'sort_order' => 9, 'updated_by' => 1]
        ];
//        DB::table('menus')->insert($data);
        $rows = DB::table('menus')->get(['menu_id']);
        $i = 0;
        foreach ($rows as $row) {
            DB::table('menus')
                ->where('menu_id', $row->menu_id)
                ->update($data[$i]);
            $i++;
        }
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
