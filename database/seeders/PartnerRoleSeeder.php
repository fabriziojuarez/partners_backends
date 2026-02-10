<?php

namespace Database\Seeders;

use App\Models\PartnerRole;
use Illuminate\Database\Seeder;

class PartnerRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PartnerRole::create([
            'name' => 'Barista Part Time',
            'hierarchy' => 1,
            'prefix' => 'PT',
            'description' => 'Realizar las evaluaciones antes de finalizar el mes'
        ]);

        PartnerRole::create([
            'name' => 'Barista Full Time',
            'hierarchy' => 1,
            'prefix' => 'FT',
            'description' => 'Realizar las evaluaciones antes de finalizar el mes'
        ]);

        PartnerRole::create([
            'name' => 'Barista Trainer',
            'hierarchy' => 2,
            'prefix' => 'BT',
            'description' => 'Administrar de partners FT y PT, cursos y evaluar'
        ]);

        PartnerRole::create([
            'name' => 'Asistente de tienda',
            'hierarchy' => 3,
            'prefix' => 'SSV',
            'description' => 'Administracion de partners y ascenderlos hasta BT'
        ]);

        PartnerRole::create([
            'name' => 'Gerente de tienda',
            'hierarchy' => 4,
            'prefix' => 'SM',
            'description' => 'Administracion de partners y ascenderlos hasta SSV',
        ]);
    }
}
