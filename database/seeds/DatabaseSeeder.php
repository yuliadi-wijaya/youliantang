<?php

use Database\Seeders\AppSettingSeeder;
use Database\Seeders\MedicalInfoSeeder;
use Database\Seeders\NotificationTypeSeeder;
use Database\Seeders\DoctorAvailableDaySeeder;
use Database\Seeders\DoctorAvailableSlotSeeder;
use Database\Seeders\DoctorAvailableTimeSeeder;
use Database\Seeders\MembershipSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\RoomSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
            ReceptionistSeeder::class,
            MedicalInfoSeeder::class,
            NotificationTypeSeeder::class,
            DoctorAvailableDaySeeder::class,
            DoctorAvailableTimeSeeder::class,
            DoctorAvailableSlotSeeder::class,
            MembershipSeeder::class,
            ProductSeeder::class,
            RoomSeeder::class,
        ]);
    }
}
