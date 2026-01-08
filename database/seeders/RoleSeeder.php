<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Barista Part Time',
            'prefix' => 'PT',
        ]);

        Role::create([
            'name' => 'Barista Full Time',
            'prefix' => 'FT',
        ]);

        Role::create([
            'name' => 'Barista Trainer',
            'prefix' => 'BT',
        ]);

        Role::create([
            'name' => 'Asistente de tienda',
            'prefix' => 'SSV',
        ]);

        Role::create([
            'name' => 'Gerente de tienda',
            'prefix' => 'SM',
        ]);
    }
}
