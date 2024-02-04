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
        // $faker = faker::create();
        // foreach (range(4, 8) as $item) {
        //     $fakerName = $faker->name;
        //     $user = [
        //         'first_name' => Str::before($fakerName, ' '),
        //         'last_name' => Str::after($fakerName, ' '),
        //         'phone_number' => '08' . rand(2000000000, 2099999999),
        //         'profile_photo' => 'avatar-4.jpg',
        //         'email' => $faker->safeEmail,
        //         'password' => 'therapist123',
        //     ];
        //     $user = Sentinel::registerAndActivate($user);
        //     $role = Sentinel::findRoleBySlug('therapist');
        //     $role->users()->attach($user);
        // }
        // foreach (range(4, 8) as $item) {
        //     DB::table('therapists')->insert([
        //         'user_id' => $item,
        //         'ktp' => rand(2000000000000000, 2099999999999999),
        //         'gender' => 'Male',
        //         'address' => $faker->address,
        //         'place_of_birth' => 'Jakarta',
        //         'birth_date' => $faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
        //         'rekening_number' => rand(20200000, 20209999),
        //         'emergency_contact' => '0852' . $faker->numberBetween(10000000, 20000000),
        //         'emergency_name' => Str::before($faker->name, ' '),
        //         'created_by' => 1,
        //         'updated_by' => 1,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //         'status' => 1,
        //     ]);
        // }
    }
}
