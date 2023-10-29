<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            'name' => "VIP Room 1",
            'description' => "VIP 1",
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('rooms')->insert([
            'name' => "VIP Room 2",
            'description' => "VIP 2",
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('rooms')->insert([
            'name' => "Regular Room 1",
            'description' => "Regular 1",
            'status' => 1,
            'created_at' => now(),
        ]);

        DB::table('rooms')->insert([
            'name' => "Regular Room 1",
            'description' => "Regular 1",
            'status' => 1,
            'created_at' => now(),
        ]);
    }
}
