<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if (!Schema::hasTable('menus')) {
            Schema::create('menus', function (Blueprint $table) {
                $table->bigIncrements('menu_id');
                $table->string('menu_name')->nullable(false);
                $table->string('menu_description')->nullable();
                $table->string('menu_url')->nullable();
                $table->integer('sort_order')->nullable(false);
                $table->integer('parent_id')->default(0);
                $table->string('menu_icon')->nullable();
                $table->integer('is_active')->default(1);
                $table->integer('is_lock')->default(0);
                $table->integer('is_delete')->default(0);
                $table->integer('created_by')->default(0);
                $table->integer('updated_by')->default(0);
                $table->timestamps();
            });
            // Insert some stuff
            $data = [
                ['menu_name' => 'Dashboard', 'parent_id' => 0, 'menu_description' => 'Dashboard Menu', 'menu_url' => '/admin/dashboard', 'sort_order' => '1',  'menu_icon' => 'md-view-dashboard', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Groups', 'parent_id' => 0, 'menu_description' => 'Groups Menu', 'menu_url' => '/admin/groups', 'sort_order' => '2',  'menu_icon' => 'md-accounts', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Roles', 'parent_id' => 0, 'menu_description' => 'Roles Menu', 'menu_url' => '/admin/roles', 'sort_order' => '3',  'menu_icon' => 'md-nature-people', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Users', 'parent_id' => 0, 'menu_description' => 'Users Menu', 'menu_url' => '/admin/users', 'sort_order' => '4',  'menu_icon' => 'md-account', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Menus', 'parent_id' => 0, 'menu_description' => 'Menus', 'menu_url' => '/admin/menus', 'sort_order' => '5',  'menu_icon' => '	md-palette', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Hospitals', 'parent_id' => 0, 'menu_description' => 'Hospitals Menu', 'menu_url' => '/admin/hospitals', 'sort_order' => '6',  'menu_icon' => 'md-city-alt', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Pages', 'parent_id' => 0, 'menu_description' => 'Pages', 'menu_url' => '/admin/pages', 'sort_order' => '7',  'menu_icon' => 'md-file', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Billing', 'parent_id' => 0, 'menu_description' => 'Billing Menu', 'menu_url' => '/admin/billing', 'sort_order' => '8',  'menu_icon' => 'md-money-box', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Schedule Management', 'parent_id' => 0, 'menu_description' => 'Schedule Management', 'menu_url' => '/admin/schedule', 'sort_order' => '9',  'menu_icon' => 'md-calendar-check', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Slot Management', 'parent_id' => 0, 'menu_description' => 'Slot Management', 'menu_url' => '/admin/slots', 'sort_order' => '10',  'menu_icon' => 'md-border-all', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Site Management', 'parent_id' => 0, 'menu_description' => 'Site Management', 'menu_url' => '/admin/sitemanagement', 'sort_order' => '11',  'menu_icon' => 'md-view-dashboard', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Doctors', 'parent_id' => 0, 'menu_description' => 'Doctors', 'menu_url' => '/admin/doctors', 'sort_order' => '12',  'menu_icon' => 'md-accounts-outline', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Doctor Metatype', 'parent_id' => 0, 'menu_description' => 'Doctor Metatype', 'menu_url' => '/admin/settings/doctorsmetatypes', 'sort_order' => '13',  'menu_icon' => 'md-info-outline', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Patient Metatype', 'parent_id' => 0, 'menu_description' => 'Patient Metatype', 'menu_url' => '/admin/settings/patientsmetatypes', 'sort_order' => '14',  'menu_icon' => 'md-info', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Patients', 'parent_id' => 0, 'menu_description' => 'Patients', 'menu_url' => '/admin/members', 'sort_order' => '15',  'menu_icon' => 'md-airline-seat-individual-suite', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Specilizations', 'parent_id' => 0, 'menu_description' => 'Specilizations', 'menu_url' => '/admin/specializations', 'sort_order' => '17',  'menu_icon' => 'md-lamp', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Settings', 'parent_id' => 0, 'menu_description' => 'Settings', 'menu_url' => '/admin/settings', 'sort_order' => '16',  'menu_icon' => 'md-view-dashboard', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Consultation Types', 'parent_id' => 0, 'menu_description' => 'Consultation Types', 'menu_url' => '/admin/consultationtypes', 'sort_order' => '18',  'menu_icon' => 'md-view-dashboard', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'API configurations', 'parent_id' => 0, 'menu_description' => 'API configurations', 'menu_url' => '/admin/settings/apiconfigurations', 'sort_order' => '19',  'menu_icon' => 'md-view-dashboard', 'created_by' => 1, 'is_lock' => 1],
                ['menu_name' => 'Contacts', 'parent_id' => 0, 'menu_description' => 'Contacts', 'menu_url' => '/admin/contacts', 'sort_order' => '20',  'menu_icon' => 'md-view-dashboard', 'created_by' => 1, 'is_lock' => 1]
            ];
            DB::table('menus')->insert($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('menus');
    }

}
