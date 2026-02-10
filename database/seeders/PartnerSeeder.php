<?php

namespace Database\Seeders;

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
            'partner_role_id' => 1,
            'user_id' => 1,
        ]);

        Partner::create([
            'name' => 'Daniel Quevedo',
            'partner_role_id' => 3,
            'user_id' => 2,
        ]);

        Partner::create([
            'name' => 'Patrick Ruiz',
            'partner_role_id' => 2,
            'user_id' => 3,
        ]);

        Partner::create([
            'name' => 'Shirley',
            'partner_role_id' => 1,
            'user_id' => 4,
        ]);

        Partner::create([
            'name' => 'Joselyn Pino',
            'partner_role_id' => 4,
            'user_id' => 5,
        ]);

        Partner::create([
            'name' => 'Ricardo Manyari',
            'partner_role_id' => 5,
            'user_id' => 6,
        ]);
    }
}
