<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'fabri139',
            'password' => 10011,
            'user_role_id' => 2,
        ]);

        User::create([
            'name' => 'Daniel139',
            'password' => 10015,
        ]);

        User::create([
            'name' => 'Pat139',
            'password' => 10016,
        ]);

        User::create([
            'name' => 'Shirley139',
            'password' => 10019,
        ]);

        User::create([
            'name' => 'Josy139',
            'password' => 11111,
        ]);

        User::create([
            'name' => 'ric139',
            'password' => 22222,
        ]);
    }
}
