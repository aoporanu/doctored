<?php

use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		  DB::table('pages')->insert([
            'title' => 'terms and conditions',
            'slug' =>  'terms-and-conditions',
            'description' =>'Terms and conditions'
        ]);
		
		 DB::table('pages')->insert([
            'title' => 'about us',
            'slug' =>  'about-us',
            'description' =>'about us'
        ]);
		
		 DB::table('pages')->insert([
            'title' => 'privacy policy',
            'slug' =>  'privacy-policy',
            'description' =>'privacy policy'
        ]);
		
		DB::table('pages')->insert([
            'title' => 'sitemap',
            'slug' =>  'sitemap',
            'description' =>'sitemap'
        ]);
		
		DB::table('pages')->insert([
            'title' => 'how does it work',
            'slug' =>  'how-does-it-work',
            'description' =>'how does it work'
        ]);
		
		DB::table('site_management')->insert([
            'sitename' => 'Doctored Site',
            'copyright' =>  'doctored'
        ]);
		
		DB::table('menus')->insert([
            'menu_name' => 'Dashboard',
            'menu_description' =>  'Dashboard',
			'parent_id' =>  0,
			'menu_url' =>  '/admin/dashboard',
			'sort_order' =>  1,
			'menu_icon' =>  'md-view-dashboard'
        ]);
		
		DB::table('menus')->insert([
            'menu_name' => 'Groups',
            'menu_description' =>  'groups',
			'parent_id' =>  0,
			'menu_url' =>  '/admin/groups',
			'sort_order' =>  2,
			'menu_icon' =>  'md-view-compact'
        ]);
		
		DB::table('menus')->insert([
            'menu_name' => 'Roles',
            'menu_description' =>  'roles',
			'parent_id' =>  0,
			'menu_url' =>  '/admin/roles',
			'sort_order' =>  3,
			'menu_icon' =>  'md-widgets'
        ]);
		
		DB::table('menus')->insert([
            'menu_name' => 'Users',
            'menu_description' =>  'users',
			'parent_id' =>  0,
			'menu_url' =>  '/admin/users',
			'sort_order' =>  4,
			'menu_icon' =>  'md-puzzle-piece'
        ]);
		
		DB::table('menus')->insert([
            'menu_name' => 'Menus',
            'menu_description' =>  'menus',
			'parent_id' =>  0,
			'menu_url' =>  '/admin/menus',
			'sort_order' =>  5,
			'menu_icon' =>  'md-palette'
        ]);
		
		DB::table('menus')->insert([
            'menu_name' => 'Hospitals',
            'menu_description' =>  'hospitals',
			'parent_id' =>  0,
			'menu_url' =>  '/admin/hospitals',
			'sort_order' =>  6,
			'menu_icon' =>  'md-format-color-fill'
        ]);
		
		DB::table('menus')->insert([
            'menu_name' => 'Pages',
            'menu_description' =>  'pages',
			'parent_id' =>  0,
			'menu_url' =>  '/admin/pages',
			'sort_order' =>  7,
			'menu_icon' =>  'md-google-pages'
        ]);
		
		DB::table('menus')->insert([
            'menu_name' => 'Billing',
            'menu_description' =>  'billing',
			'parent_id' =>  0,
			'menu_url' =>  '/admin/billing',
			'sort_order' =>  8,
			'menu_icon' =>  'md-chart'
        ]);
		
		DB::table('menus')->insert([
            'menu_name' => 'Schedule',
            'menu_description' =>  'schedule',
			'parent_id' =>  0,
			'menu_url' =>  '/admin/schedule',
			'sort_order' =>  9,
			'menu_icon' =>  'md-comment-alt-text'
        ]);
		
		DB::table('menus')->insert([
            'menu_name' => 'Slots',
            'menu_description' =>  'slots',
			'parent_id' =>  0,
			'menu_url' =>  '/admin/slots',
			'sort_order' =>  10,
			'menu_icon' =>  'md-border-all'
        ]);
		
		DB::table('menus')->insert([
            'menu_name' => 'Sitemanagement',
            'menu_description' =>  'sitemanagement',
			'parent_id' =>  0,
			'menu_url' =>  '/admin/sitemanagement',
			'sort_order' =>  10,
			'menu_icon' =>  'md-apps'
        ]);
    }
}
