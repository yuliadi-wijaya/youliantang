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
            'name' => "Happy Hour - Refleksi 90 menit",
            'duration' => 90,
            'price' => 110000,
            'commission_fee' => 30000,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Happy Hour - Refleksi 120 menit",
            'duration' => 120,
            'price' => 135000,
            'commission_fee' => 50000,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Body Massage - Traditional 90 menit",
            'duration' => 90,
            'price' => 230000,
            'commission_fee' => 50000,
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('products')->insert([
            'name' => "Body Massage - Traditional 120 menit",
            'duration' => 120,
            'price' => 285000,
            'commission_fee' => 50000,
            'status' => 1,
            'created_at' => now(),
        ]);
    }
}
