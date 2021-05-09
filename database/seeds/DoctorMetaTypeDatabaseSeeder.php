<?php

use Illuminate\Database\Seeder;

class DoctorMetaTypeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('doctor_metatypes')->insert([
            'dmetaname' => 'achievement',
            'dmetakey' =>  'achievement'
		]);
		
		DB::table('doctor_metatypes')->insert([
            'dmetaname' => 'professional experience',
            'dmetakey' =>  'professional_experience'
		]);
		DB::table('doctor_metatypes')->insert([
            'dmetaname' => 'qualification',
            'dmetakey' =>  'qualification'
		]);
		DB::table('doctor_metatypes')->insert([
            'dmetaname' => 'seminars',
            'dmetakey' =>  'seminars'
		]);
    }
}
