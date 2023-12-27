<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Faker\Factory as faker;
use Illuminate\Support\Str;

class TherapistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $faker = faker::create();
        foreach (range(3, 15) as $item) {
            $fakerName = $faker->name;
            $user = [
                'first_name' => Str::before($fakerName, ' '),
                'last_name' => Str::after($fakerName, ' '),
                'phone_number' => rand(1000000000000000, 2000000000000000),
                'profile_photo' => 'dr-avatar-' . $item . '.jpg',
                'email' => $faker->safeEmail,
                'password' => 'therapist@123456',
            ];
            $user = Sentinel::registerAndActivate($user);
            $role = Sentinel::findRoleBySlug('therapist');
            $role->users()->attach($user);
        }
        foreach (range(3, 15) as $item) {
            DB::table('therapists')->insert([
                'user_id' => $item,
                'title' => $faker->title,
                'fees' => '500',
                'degree' => 'MBBS',
                'experience' => $item . 'year',
                'slot_time' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        */
    }
}
