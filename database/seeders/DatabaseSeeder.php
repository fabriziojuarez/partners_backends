<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// SEEDERS
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PartnerSeeder;
use Database\Seeders\PartnerRoleSeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\CourseTopicSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserRoleSeeder::class,
            UserSeeder::class,
            PartnerRoleSeeder::class,
            PartnerSeeder::class,
            CourseSeeder::class,
            CourseTopicSeeder::class,
        ]);
    }
}
