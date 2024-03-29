<?php

// namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User Data
        $credentials = [
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'phone_number' => '5142323114',
            'profile_photo' =>'avatar-1.jpg',
            'email' => 'admin@youliantang.com',
            'password' => 'admin123',
            'status' => 1,
        ];
        $user = Sentinel::registerAndActivate( $credentials );
        $role = Sentinel::findRoleBySlug('admin');
        $role->users()->attach($user);

        // Role Access Data
        DB::table('role_access')->insert([
            'user_id' => 1,
            'access_code' => 'ALL',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
