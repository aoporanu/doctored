<?php

use Illuminate\Database\Seeder;

class TimezonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timezones')->insert([
            'countrycode' => 'RO',
            'timezone' => 'Europe/Bucharest'
        ]);
    }
}
