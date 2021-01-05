<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
        	'name' => 'admin',
        	'email' => 'admin@gmail.com',
        	'password' => bcrypt('password'),
        	'phone' => '9842089687',
        	'role' => 'admin'
        ]);
    }
}
