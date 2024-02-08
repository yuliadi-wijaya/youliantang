<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TherapistAvailableSlotSeeder extends Seeder
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
            DB::table('therapist_available_slots')->insert([
                'therapist_id' => $item,
                'therapist_available_time_id' => $item,
                'from' => '10:00:00',
                'to' => '12:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('therapist_available_slots')->insert([
                'therapist_id' => $item,
                'therapist_available_time_id' => $item,
                'from' => '16:00:00',
                'to' => '17:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        */
    }
}
