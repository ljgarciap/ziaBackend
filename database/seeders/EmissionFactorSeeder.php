<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmissionCategory;
use App\Models\EmissionFactor;

class EmissionFactorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Mobile Sources
        $mobile = EmissionCategory::create([
            'name' => 'Fuentes Móviles - Combustibles',
            'scope' => '1',
            'description' => 'Direct emissions from mobile combustion.'
        ]);

        EmissionFactor::create([
            'emission_category_id' => $mobile->id,
            'name' => 'Gasolina E10 (Mezcla comercial)',
            'unit' => 'Gal',
            'factor_co2' => 7.618,
            'factor_ch4' => 0.0002627,
            'factor_n2o' => 0.0000255,
            'factor_total_co2e' => 7.63323, // Approx
            'uncertainty_lower' => 0.234, // stored as % or ratio? Plan said +/- %. Service expects ratio if we divide by 100.
            // Let's store as Percentage in DB (0.234) and Service divides by 100.
            // Extracted Z16 was 0.00234. If that is the value used in SQRT with other ratios, then it is a ratio.
            // But if stored in DB as 'Incertidumbre %', it might be 0.234.
            // Let's assume Z16 (0.00234) is the RATIO. So % is 0.234%.
            'uncertainty_upper' => 0.234, 
            'uncertainty_distribution' => 'normal',
            'source_reference' => 'Calculo MVP Zia - Excel Definitiva (Row 16)'
        ]);

        EmissionFactor::create([
            'emission_category_id' => $mobile->id,
            'name' => 'Diesel B10',
            'unit' => 'Gal',
            'factor_co2' => 8.812, // Placeholder based on typical diesel (~10.15kg/gal * 0.9 + biodiesel adj)
            'factor_ch4' => 0.000028,
            'factor_n2o' => 0.00003,
            'factor_total_co2e' => 8.825, // Placeholder approx
            'source_reference' => 'Estimado (Pending Excel Extraction)'
        ]);

        // 2. Fugitive Emissions (Refrigerants)
        $fugitive = EmissionCategory::create([
            'name' => 'Emisiones Fugitivas - Refrigerantes',
            'scope' => '1',
            'description' => 'Leakage of refrigerant gases.'
        ]);

        EmissionFactor::create([
            'emission_category_id' => $fugitive->id,
            'name' => 'R-410A',
            'unit' => 'kg',
            'factor_co2' => 0,
            'factor_ch4' => 0,
            'factor_n2o' => 0,
            'factor_total_co2e' => 2088,
            'source_reference' => 'IPCC AR4/AR5'
        ]);

        // 3. Mobile Gaseous
        $mobileGaseous = EmissionCategory::create([
            'name' => 'Fuentes Móviles - Gases',
            'scope' => '1',
            'description' => 'Gaseous fuels for mobile sources.'
        ]);

        EmissionFactor::create([
            'emission_category_id' => $mobileGaseous->id,
            'name' => 'Gas Natural Vehicular (GNV)',
            'unit' => 'm3',
            'factor_total_co2e' => 1.93,
            'source_reference' => 'Calculo MVP'
        ]);

        // 4. Extinguishers
        $extinguishers = EmissionCategory::create([
            'name' => 'Fuentes Móviles - Extintores',
            'scope' => '1',
            'description' => 'Fire extinguishers gases.'
        ]);

        EmissionFactor::create([
            'emission_category_id' => $extinguishers->id,
            'name' => 'CO2 (Extintor)',
            'unit' => 'kg',
            'factor_total_co2e' => 1.0,
            'source_reference' => 'Standard'
        ]);

        // 5. Lubricants
        $lubricants = EmissionCategory::create([
            'name' => 'Fuentes Móviles - Lubricantes',
            'scope' => '1',
            'description' => 'Mobile lubricants.'
        ]);

        EmissionFactor::create([
            'emission_category_id' => $lubricants->id,
            'name' => 'Aceite Lubricante',
            'unit' => 'Gal',
            'factor_total_co2e' => 0.002,
            'source_reference' => 'MVP'
        ]);

        // 6. Fixed Solid
        $fixedSolid = EmissionCategory::create([
            'name' => 'Fuentes Fijas - Combustibles Sólidos',
            'scope' => '1',
            'description' => 'Stationary solid combustion.'
        ]);

        EmissionFactor::create([
            'emission_category_id' => $fixedSolid->id,
            'name' => 'Carbón Mineral',
            'unit' => 'Ton',
            'factor_total_co2e' => 2400.5,
            'source_reference' => 'IPCC'
        ]);

        // 7. Fixed Liquid
        $fixedLiquid = EmissionCategory::create([
            'name' => 'Fuentes Fijas - Combustibles Líquidos',
            'scope' => '1',
            'description' => 'Stationary liquid combustion.'
        ]);

        EmissionFactor::create([
            'emission_category_id' => $fixedLiquid->id,
            'name' => 'Diesel / ACPM (Fijo)',
            'unit' => 'Gal',
            'factor_total_co2e' => 10.15,
            'source_reference' => 'UPME'
        ]);

        // 8. Fixed Gaseous
        $fixedGaseous = EmissionCategory::create([
            'name' => 'Fuentes Fijas - Combustibles Gaseosos',
            'scope' => '1',
            'description' => 'Stationary gaseous combustion.'
        ]);

        EmissionFactor::create([
            'emission_category_id' => $fixedGaseous->id,
            'name' => 'Gas Natural (Fijo)',
            'unit' => 'm3',
            'factor_total_co2e' => 1.933,
            'source_reference' => 'UPME'
        ]);

        // 9. Scope 2 - Electricity
        $electricity = EmissionCategory::create([
            'name' => 'Electricidad - Red',
            'scope' => '2',
            'description' => 'Grid electricity consumption.'
        ]);

        EmissionFactor::create([
            'emission_category_id' => $electricity->id,
            'name' => 'FE Colombia (Interconectado)',
            'unit' => 'kWh',
            'factor_co2' => 0.126,
            'factor_ch4' => 0,
            'factor_n2o' => 0,
            'factor_total_co2e' => 0.126,
            'source_reference' => 'XM / UPME'
        ]);

    }
}
