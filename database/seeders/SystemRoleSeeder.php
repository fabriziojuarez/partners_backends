<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SystemRole;

class SystemRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemRole::create([
            'name' => 'Usuario',
            'description' => 'Usuario comun',
        ]);

        SystemRole::create([
            'name' => 'Administrador',
            'description' => 'Contiene acceso a todas las funcionalidades del sistema',
        ]);
    }
}
