<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as faker;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = faker::create();
        DB::table('promos')->insert([
            'name' => 'Grad Opening Promo 10%',
            'description' => 'Grad Opening Promo 10%',
            'discount_type' => 1,
            'discount_value' => 10,
            'discount_max_value' => 10000,
            'active_period_start' => Carbon::now(),
            'active_period_end' => Carbon::now()->addMonths(3),
            'is_reuse_voucher' => 0,
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);

        foreach (range(1,5) as $index) {
            DB::table('promo_vouchers')->insert([
                'promo_id' => 1,
                'voucher_code' => 'GRANDOPENING' . Carbon::now()->format('Ymd') . $faker->unique()->numerify('#####'),
            ]);
        }
    }
}
