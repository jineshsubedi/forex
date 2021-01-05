<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Setting::create([
        	'app_name' => 'JINESH SUBEDI',
        	'url' => 'http://localhost:8000',
        	'sub_name' => 'your slogan',
        	'email' => 'jinesh@mail.com',
        	'address' => 'Biratnagar',
            'phone_number1' => '9842089687',
        	'phone_number2' => '9842089687',
        ]);
    }
}
