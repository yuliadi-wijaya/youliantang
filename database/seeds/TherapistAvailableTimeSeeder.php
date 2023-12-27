<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TherapistAvailableTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        foreach (range(1, 15) as $item) {
            DB::table('therapist_available_times')->insert([
                'therapist_id' => $item,
                'from' => '10:00:00',
                'to' => '17:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        */
    }
}
