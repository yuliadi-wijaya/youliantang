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
        $faker = faker::create();
        $fakerName = $faker->name;

        $user = [
            'first_name' => Str::before($fakerName, ' '),
            'last_name' => Str::after($fakerName, ' '),
            'phone_number' => '0857' . $faker->numberBetween(10000000, 20000000),
            'profile_photo' => 'Male_patient.png',
            'email' => 'customer@example.com',
            'password' => '123456',
            'status' => 1,
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = Sentinel::findRoleBySlug('customer');
        $role->users()->attach($user);

        DB::table('customers')->insert([
            'user_id' => 3,
            'age' => 20,
            'place_of_birth' => 'Jakarta',
            'birth_date' => $faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
            'gender' => 'Male',
            'address' => $faker->address,
            'emergency_contact' => '0857' . $faker->numberBetween(10000000, 20000000),
            'emergency_name' => Str::before($fakerName, ' '),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'status' => 1,
        ]);
        /*
        $i = 1;
        foreach (range(17, 30) as $item) {
            $fakerName = $faker->name;
            $user = [
                'first_name' => Str::before($fakerName, ' '),
                'last_name' => Str::after($fakerName, ' '),
                'phone_number' => rand(1000000000, 2000000000),
                'profile_photo' => 'avatar-' . $i . '.jpg',
                'email' => $faker->safeEmail,
                'password' => 'customer@123456',
            ];
            $user = Sentinel::registerAndActivate($user);
            $role = Sentinel::findRoleBySlug('customer');
            $role->users()->attach($user);
            $i++;
        }
        foreach (range(17, 30) as $item) {
            DB::table('customers')->insert([
                'user_id' => $item,
                'age' => $item,
                'gender' => 'Male',
                'address' => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }*/
    }
}
