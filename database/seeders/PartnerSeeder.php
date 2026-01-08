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
            //'code' => 10011,
            'role_id' => 1,
            'user_id' => 1,
        ]);

        Partner::create([
            'name' => 'Daniel Quevedo',
            //'code' => 10012,
            'role_id' => 3,
            'user_id' => 2,
        ]);
    }
}
