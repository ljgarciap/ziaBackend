<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CompanySectorSeeder::class,
            CalculationFormulaSeeder::class,
            EmissionCategorySeeder::class, // Must run before EmissionFactorSeeder
            EmissionFactorSeeder::class,
            UserSeeder::class,
            CompanySeeder::class,
            CarbonEmissionSeeder::class,
        ]);
    }
}
