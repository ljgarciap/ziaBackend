<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarbonEmission;
use App\Models\EmissionFactor;
use App\Models\Period;

class SampleEmissionSeeder extends Seeder
{
    public function run(): void
    {
        // Tech Solutions SAS (Company ID 1) - Period 2024 (ID 1)
        $periodId = 1;

        // 1. Mobile - Gasoline (Factor ID 10)
        CarbonEmission::create([
            'period_id' => $periodId,
            'emission_factor_id' => 10,
            'quantity' => 500, // 500 Gallons
            'calculated_co2e' => 3.816, // (500 * 7.63323) / 1000
            'emissions_co2' => 3.809,
            'emissions_ch4' => 0.0001,
            'emissions_n2o' => 0.00001,
            'notes' => 'Sample gasoline consumption'
        ]);

        // 2. Mobile - Diesel (Factor ID 28)
        CarbonEmission::create([
            'period_id' => $periodId,
            'emission_factor_id' => 28,
            'quantity' => 1200, // 1200 Gallons
            'calculated_co2e' => 10.59, // (1200 * 8.825) / 1000 approx
            'emissions_co2' => 10.57,
            'notes' => 'Fleet diesel'
        ]);

        // 3. Electricity (Factor ID 30)
        CarbonEmission::create([
            'period_id' => $periodId,
            'emission_factor_id' => 30,
            'quantity' => 15000, // 15000 kWh
            'calculated_co2e' => 1.89, // 15000 * 0.126 / 1000
            'emissions_co2' => 1.89,
            'notes' => 'HQ office electricity'
        ]);

        // Total approx: 3.816 + 10.59 + 1.89 = 16.296 tCO2e
    }
}
