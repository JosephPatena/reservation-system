<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class OwnerCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('owner_currencies')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        \App\Models\OwnerCurrency::create([
            'currency_id' => 111
        ]);
    }
}
