<?php


use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Faker\Factory as faker;
use Illuminate\Support\Str;

class ReceptionistSeeder extends Seeder
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
            'profile_photo' => 'Female_receptionist.png',
            'email' => 'receptionist@example.com',
            'password' => '123456',
            'status' => 1,
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = Sentinel::findRoleBySlug('receptionist');
        $role->users()->attach($user);

        DB::table('receptionists')->insert([
            'therapist_id' => 1,
            'user_id' => 4,
            'ktp' => '3208081508700007',
            'gender' => 'Female',
            'address' => $faker->address,
            'place_of_birth' => 'Jakarta',
            'birth_date' => $faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
            'rekening_number' => '1234567',
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
        foreach (range(31, 45) as $item) {
            $fakerName = $faker->name;
            $user = [
                'first_name' => Str::before($fakerName, ' '),
                'last_name' => Str::after($fakerName, ' '),
                'phone_number' => rand(1000000000, 2000000000),
                'profile_photo' => 're-avatar-' . $i . '.jpg',
                'email' => $faker->safeEmail,
                'password' => 'receptionist@123456',
            ];
            $user = Sentinel::registerAndActivate($user);
            $role = Sentinel::findRoleBySlug('receptionist');
            $role->users()->attach($user);
            $i++;
        }
        */
    }
}
