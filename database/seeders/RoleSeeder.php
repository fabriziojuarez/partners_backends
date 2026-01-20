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
            'herarchy' => 1,
            'prefix' => 'PT',
        ]);

        Role::create([
            'name' => 'Barista Full Time',
            'herarchy' => 2,
            'prefix' => 'FT',
        ]);

        Role::create([
            'name' => 'Barista Trainer',
            'herarchy' => 3,
            'prefix' => 'BT',
            'description' => 'Administracion de partners FT y PT, Administracion de cursos y Evaluaciones',
        ]);

        Role::create([
            'name' => 'Asistente de tienda',
            'herarchy' => 4,
            'prefix' => 'SSV',
            'description' => 'Administracion de partners y ascenderlos hasta BT'
        ]);

        Role::create([
            'name' => 'Gerente de tienda',
            'herarchy' => 5,
            'prefix' => 'SM',
            'description' => 'Administracion de partners y ascenderlos hasta SSV',
        ]);
    }
}
