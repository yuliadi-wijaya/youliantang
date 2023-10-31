<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => "Happy Hour Refleksi 90 menit",
            'duration' => 90,
            'price' => 110000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Happy Hour Refleksi 120 menit",
            'duration' => 120,
            'price' => 135000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Regular Refleksi 90 menit",
            'duration' => 90,
            'price' => 140000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Regular Refleksi 120 menit",
            'duration' => 120,
            'price' => 170000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Body Massage Tradisional 90 menit",
            'duration' => 90,
            'price' => 230000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Body Massage Tradisional 120 menit",
            'duration' => 120,
            'price' => 285000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Body Massage Combination 90 menit",
            'duration' => 90,
            'price' => 230000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Body Massage Combination 120 menit",
            'duration' => 120,
            'price' => 285000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Body Massage Thai 90 menit",
            'duration' => 90,
            'price' => 230000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Body Massage Thai 120 menit",
            'duration' => 120,
            'price' => 285000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Sport Massage 90 menit",
            'duration' => 90,
            'price' => 350000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Sport Massage 120 menit",
            'duration' => 120,
            'price' => 400000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Aromatheraphy 90 menit",
            'duration' => 90,
            'price' => 285000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Aromatheraphy 120 menit",
            'duration' => 120,
            'price' => 330000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Candle massage 90 menit",
            'duration' => 90,
            'price' => 285000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Candle massage 120 menit",
            'duration' => 120,
            'price' => 330000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Body Scrub 90 menit",
            'duration' => 90,
            'price' => 285000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Body Scrub 120 menit",
            'duration' => 120,
            'price' => 330000,
            'commission_fee' => 0,
            'status' => 1,
            'created_at' => now(),
        ]);
    }
}
