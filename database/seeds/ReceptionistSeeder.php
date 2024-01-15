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

        // First Receptionist
        // User Data
        $user = [
            'first_name' => 'Receptionist',
            'last_name' => 'CK',
            'phone_number' => '0852' . $faker->numberBetween(10000000, 20000000),
            'profile_photo' => 'avatar-5.jpg',
            'email' => 'receptionist.ck@youliantang.com',
            'password' => 'receptionist123',
            'status' => 1,
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = Sentinel::findRoleBySlug('receptionist');
        $role->users()->attach($user);

        // Receptionist Data
        DB::table('receptionists')->insert([
            'user_id' => 2,
            'ktp' => '1011111111111111',
            'gender' => 'Female',
            'address' => $faker->address,
            'place_of_birth' => 'Jakarta',
            'birth_date' => $faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
            'rekening_number' => '101111',
            'emergency_contact' => '0852' . $faker->numberBetween(10000000, 20000000),
            'emergency_name' => Str::before($faker->name, ' '),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'status' => 1,
        ]);

        // Role Access Data
        DB::table('role_access')->insert([
            'user_id' => 2,
            'access_code' => 'CK',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // End

        // Second Receptionist
        // User Data
        $user = [
            'first_name' => 'Receptionist',
            'last_name' => 'NC',
            'phone_number' => '0852' . $faker->numberBetween(10000000, 20000000),
            'profile_photo' => 'avatar-2.jpg',
            'email' => 'receptionist.nc@youliantang.com',
            'password' => 'receptionist123',
            'status' => 1,
        ];
        $user = Sentinel::registerAndActivate($user);
        $role = Sentinel::findRoleBySlug('receptionist');
        $role->users()->attach($user);

        // Receptionist Data
        DB::table('receptionists')->insert([
            'user_id' => 3,
            'ktp' => '1022222222222222',
            'gender' => 'Male',
            'address' => $faker->address,
            'place_of_birth' => 'Jakarta',
            'birth_date' => $faker->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
            'rekening_number' => '102222',
            'emergency_contact' => '0852' . $faker->numberBetween(10000000, 20000000),
            'emergency_name' => Str::before($faker->name, ' '),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'status' => 1,
        ]);

         // Role Access Data
         DB::table('role_access')->insert([
            'user_id' => 3,
            'access_code' => 'NC',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // End
    }
}
