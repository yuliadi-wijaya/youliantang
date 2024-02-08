<?php


use Illuminate\Database\Seeder;
use Faker\Factory as faker;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = faker::create();
        // foreach (range(9, 13) as $item) {
        //     $fakerName = $faker->name;
        //     $user = [
        //         'first_name' => Str::before($fakerName, ' '),
        //         'last_name' => Str::after($fakerName, ' '),
        //         'phone_number' => rand(3010000000, 3010999999),
        //         'profile_photo' => 'avatar-3.jpg',
        //         'email' => $faker->safeEmail,
        //         'password' => 'customer123',
        //     ];
        //     $user = Sentinel::registerAndActivate($user);
        //     $role = Sentinel::findRoleBySlug('customer');
        //     $role->users()->attach($user);
        // }
        // foreach (range(9, 13) as $item) {
        //     DB::table('customers')->insert([
        //         'user_id' => $item,
        //         'ktp' => rand(3000000000000000, 3099999999999999),
        //         'gender' => 'Female',
        //         'address' => $faker->address,
        //         'place_of_birth' => 'Jakarta',
        //         'birth_date' => $faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
        //         'rekening_number' => rand(30300000, 30309999),
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
