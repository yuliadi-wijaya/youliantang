<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memberships')->insert([
            'name' => "Regular",
            'discount_type' => 0,
            'discount_value' => 1000,
            'status' => 1,
            'total_active_period' => 365,
            'created_at' => now(),
        ]);

        DB::table('memberships')->insert([
            'name' => "Gold",
            'discount_type' => 1,
            'discount_value' => 5,
            'status' => 1,
            'total_active_period' => 365,
            'created_at' => now(),
        ]);

        DB::table('memberships')->insert([
            'name' => "Platinum",
            'discount_type' => 1,
            'discount_value' => 10,
            'status' => 1,
            'total_active_period' => 365,
            'created_at' => now(),
        ]);
    }
}
