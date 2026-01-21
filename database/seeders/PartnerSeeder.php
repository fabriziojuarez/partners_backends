<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partner::create([
            'name' => 'Fabrizio Juarez',
            'role_id' => 1,
            'user_id' => 1,
        ]);

        Partner::create([
            'name' => 'Daniel Quevedo',
            'role_id' => 3,
            'user_id' => 2,
        ]);

        Partner::create([
            'name' => 'Patrick Ruiz',
            'role_id' => 2,
            'user_id' => 3,
        ]);

        Partner::create([
            'name' => 'Shirley',
            'role_id' => 1,
            'user_id' => 4,
        ]);
    }
}
