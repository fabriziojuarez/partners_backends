<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// SEEDERS
use Database\Seeders\SystemRoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\PartnerSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SystemRoleSeeder::class,
            UserSeeder::class,
            RoleSeeder::class,
            PartnerSeeder::class,
            CourseSeeder::class,
            TopicSeeder::class,
        ]);
    }
}
