<?php

use Database\Seeders\AppSettingSeeder;
use Database\Seeders\MedicalInfoSeeder;
use Database\Seeders\NotificationTypeSeeder;
use Database\Seeders\TherapistSeeder;
use Database\Seeders\TherapistAvailableDaySeeder;
use Database\Seeders\TherapistAvailableSlotSeeder;
use Database\Seeders\TherapistAvailableTimeSeeder;
use Database\Seeders\MembershipSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\PromoSeeder;
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
            TherapistSeeder::class,
            CustomerSeeder::class,
            ReceptionistSeeder::class,
            MedicalInfoSeeder::class,
            NotificationTypeSeeder::class,
            TherapistAvailableDaySeeder::class,
            TherapistAvailableTimeSeeder::class,
            TherapistAvailableSlotSeeder::class,
            MembershipSeeder::class,
            ProductSeeder::class,
            RoomSeeder::class,
            PromoSeeder::class
        ]);
    }
}

