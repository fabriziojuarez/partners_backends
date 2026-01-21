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
            'hierarchy' => 1,
            'prefix' => 'PT',
            'description' => 'Realizar las evaluaciones antes de finalizar el mes'
        ]);

        Role::create([
            'name' => 'Barista Full Time',
            'hierarchy' => 2,
            'prefix' => 'FT',
            'description' => 'Realizar las evaluaciones antes de finalizar el mes'
        ]);

        Role::create([
            'name' => 'Barista Trainer',
            'hierarchy' => 3,
            'prefix' => 'BT',
            'description' => 'Administrar de partners FT y PT, cursos y evaluar'
        ]);

        Role::create([
            'name' => 'Asistente de tienda',
            'hierarchy' => 4,
            'prefix' => 'SSV',
            'description' => 'Administracion de partners y ascenderlos hasta BT'
        ]);

        Role::create([
            'name' => 'Gerente de tienda',
            'hierarchy' => 5,
            'prefix' => 'SM',
            'description' => 'Administracion de partners y ascenderlos hasta SSV',
        ]);
    }
}
