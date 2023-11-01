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
        // Regular Room
        foreach(range(301, 315) as $item) {
            // ignore this
            if ($item == 304 || $item == 313 || $item == 314) {
                continue;
            }

            DB::table('rooms')->insert([
                'name' => 'Room ' . $item,
                'description' => 'Room ' . $item,
                'status' => 1,
                'created_at' => now(),
            ]);
        }

        // VIP Room 
        foreach(range(1, 5) as $item) {
            // ignore this
            if ($item == 4) {
                continue;
            }

            DB::table('rooms')->insert([
                'name' => "VIP " . $item,
                'description' => "VIP " . $item,
                'status' => 1,
                'created_at' => now(),
            ]);
        }
    }
}
