<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('payment_methods')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        \App\Models\PaymentMethod::create([
            'name' => 'Pay Upon Arrival',
            'description' => 'Pay only when you arrive on Site.',
            'is_available' => true
        ]);

        \App\Models\PaymentMethod::create([
            'name' => 'Pay via PayPal',
            'description' => "When you click 'Place Order' below we'll take you to PayPal's site to set up your billing information.",
            'is_available' => false
        ]);

        \App\Models\PaymentMethod::create([
            'name' => 'Pay via Stripe',
            'description' => "When you click 'Place Order' below we'll take you to Stripe's site to set up your billing information.",
            'is_available' => false
        ]);

        \App\Models\PaymentMethod::create([
            'name' => 'pay via PayMaya',
            'description' => "When you click 'Place Order' below we'll take you to PayMaya's site to set up your billing information.",
            'is_available' => false
        ]);
    }
}
