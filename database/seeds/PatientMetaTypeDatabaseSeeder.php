<?php

use Illuminate\Database\Seeder;

class PatientMetaTypeDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('patient_metatypes')->insert([
            'pmetaname' => 'achievement',
            'pmetakey' =>  'achievement'
		]);
		
		DB::table('patient_metatypes')->insert([
            'pmetaname' => 'professional experience',
            'pmetakey' =>  'professional_experience'
		]);
		DB::table('patient_metatypes')->insert([
            'pmetaname' => 'qualification',
            'pmetakey' =>  'qualification'
		]);
		DB::table('patient_metatypes')->insert([
            'pmetaname' => 'seminars',
            'pmetakey' =>  'seminars'
		]);
    }
}
