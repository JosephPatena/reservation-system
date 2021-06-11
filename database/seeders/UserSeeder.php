<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        \App\Models\User::create([
        	'role_id' => 1,
        	'name' => 'Administrator',
        	'email' => 'admin@rs',
        	'password' => Hash::make('admin@pass1234')
        ]);
    }
}
