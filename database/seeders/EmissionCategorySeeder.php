<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmissionCategory;

class EmissionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Scope 1
            ['name' => 'Fuentes Móviles - Combustibles', 'scope' => '1'],
            ['name' => 'Fuentes Móviles - Gases', 'scope' => '1'],
            ['name' => 'Emisiones Fugitivas - Refrigerantes', 'scope' => '1'],
            ['name' => 'Fuentes Móviles - Extintores', 'scope' => '1'],
            ['name' => 'Fuentes Móviles - Lubricantes', 'scope' => '1'],
            ['name' => 'Fuentes Fijas - Combustibles Sólidos', 'scope' => '1'],
            ['name' => 'Fuentes Fijas - Combustibles Líquidos', 'scope' => '1'],
            ['name' => 'Fuentes Fijas - Combustibles Gaseosos', 'scope' => '1'],
            
            // Scope 2
            ['name' => 'Electricidad - Red', 'scope' => '2'],
            
            // Scope 3 - Otras Fuentes
            ['name' => 'Viajes Aéreos', 'scope' => '3'],
            ['name' => 'Trabajo Remoto', 'scope' => '3'],
        ];

        foreach ($categories as $cat) {
            EmissionCategory::firstOrCreate(
                ['name' => $cat['name']],
                ['scope' => $cat['scope']]
            );
        }

        $this->command->info('✅ Emission categories created successfully');
    }
}
