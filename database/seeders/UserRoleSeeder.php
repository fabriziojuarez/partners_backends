<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserRole::create([
            'name' => 'Usuario',
            'description' => 'Usuario comun',
        ]);

        UserRole::create([
            'name' => 'Administrador',
            'description' => 'Administracion completa de partners y cursos',
        ]);
    }
}
