<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('statuses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $statuses = [
            'Reserved',
            'Cancelled',
            'Check In',
            'Check Out'
        ];
        foreach ($statuses as $key => $value) {
            \App\Models\Status::create(['name' => $value]);
        }
    }
}
