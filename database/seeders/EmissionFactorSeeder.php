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
        // Fetch Formula IDs
        $stdFormulaId = \DB::table('calculation_formulas')->where('name', 'like', '%Combustión Estándar%')->value('id');
        $mobileFormulaId = \DB::table('calculation_formulas')->where('name', 'like', '%Combustión Móvil%')->value('id');

        // 1. Mobile Sources
        $mobile = EmissionCategory::firstOrCreate(
            ['name' => 'Fuentes Móviles - Combustibles'],
            [
                'scope' => '1',
                'description' => 'Direct emissions from mobile combustion.'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'Gasolina E10 (Mezcla comercial)', 'emission_category_id' => $mobile->id],
            [
                'unit' => 'Gal',
                'calculation_formula_id' => $mobileFormulaId,
                'factor_co2' => 7.618,
                'factor_ch4' => 0.0002627,
                'factor_n2o' => 0.0000255,
                'factor_total_co2e' => 7.63323,
                'uncertainty_lower' => 0.234,
                'uncertainty_upper' => 0.234, 
                'uncertainty_distribution' => 'normal',
                'source_reference' => 'Calculo MVP Zia - Excel Definitiva (Row 16)'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'Diesel B10', 'emission_category_id' => $mobile->id],
            [
                'unit' => 'Gal',
                'calculation_formula_id' => $mobileFormulaId,
                'factor_co2' => 8.812,
                'factor_ch4' => 0.000028,
                'factor_n2o' => 0.00003,
                'factor_total_co2e' => 8.825,
                'source_reference' => 'Estimado (Pending Excel Extraction)'
            ]
        );

        // 2. Fugitive Emissions (Refrigerants)
        $fugitive = EmissionCategory::firstOrCreate(
            ['name' => 'Emisiones Fugitivas - Refrigerantes'],
            [
                'scope' => '1',
                'description' => 'Leakage of refrigerant gases.'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'R-410A', 'emission_category_id' => $fugitive->id],
            [
                'unit' => 'kg',
                'factor_co2' => 0,
                'factor_ch4' => 0,
                'factor_n2o' => 0,
                'factor_total_co2e' => 2088,
                'source_reference' => 'IPCC AR4/AR5'
            ]
        );

        // 3. Mobile Gaseous
        $mobileGaseous = EmissionCategory::firstOrCreate(
            ['name' => 'Fuentes Móviles - Gases'],
            [
                'scope' => '1',
                'description' => 'Gaseous fuels for mobile sources.'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'Gas Natural Vehicular (GNV)', 'emission_category_id' => $mobileGaseous->id],
            [
                'unit' => 'm3',
                'factor_total_co2e' => 1.93,
                'source_reference' => 'Calculo MVP'
            ]
        );

        // 4. Extinguishers
        $extinguishers = EmissionCategory::firstOrCreate(
            ['name' => 'Fuentes Móviles - Extintores'],
            [
                'scope' => '1',
                'description' => 'Fire extinguishers gases.'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'CO2 (Extintor)', 'emission_category_id' => $extinguishers->id],
            [
                'unit' => 'kg',
                'factor_total_co2e' => 1.0,
                'source_reference' => 'Standard'
            ]
        );

        // 5. Lubricants
        $lubricants = EmissionCategory::firstOrCreate(
            ['name' => 'Fuentes Móviles - Lubricantes'],
            [
                'scope' => '1',
                'description' => 'Mobile lubricants.'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'Aceite Lubricante', 'emission_category_id' => $lubricants->id],
            [
                'unit' => 'Gal',
                'factor_total_co2e' => 0.002,
                'source_reference' => 'MVP'
            ]
        );

        // 6. Fixed Solid
        $fixedSolid = EmissionCategory::firstOrCreate(
            ['name' => 'Fuentes Fijas - Combustibles Sólidos'],
            [
                'scope' => '1',
                'description' => 'Stationary solid combustion.'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'Carbón Mineral', 'emission_category_id' => $fixedSolid->id],
            [
                'unit' => 'Ton',
                'factor_total_co2e' => 2400.5,
                'source_reference' => 'IPCC'
            ]
        );

        // 7. Fixed Liquid
        $fixedLiquid = EmissionCategory::firstOrCreate(
            ['name' => 'Fuentes Fijas - Combustibles Líquidos'],
            [
                'scope' => '1',
                'description' => 'Stationary liquid combustion.'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'Diesel / ACPM (Fijo)', 'emission_category_id' => $fixedLiquid->id],
            [
                'unit' => 'Gal',
                'factor_total_co2e' => 10.15,
                'source_reference' => 'UPME'
            ]
        );

        // 8. Fixed Gaseous
        $fixedGaseous = EmissionCategory::firstOrCreate(
            ['name' => 'Fuentes Fijas - Combustibles Gaseosos'],
            [
                'scope' => '1',
                'description' => 'Stationary gaseous combustion.'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'Gas Natural (Fijo)', 'emission_category_id' => $fixedGaseous->id],
            [
                'unit' => 'm3',
                'calculation_formula_id' => $stdFormulaId,
                'factor_total_co2e' => 1.933,
                'source_reference' => 'UPME'
            ]
        );

        // 9. Scope 2 - Electricity
        $electricity = EmissionCategory::firstOrCreate(
            ['name' => 'Electricidad - Red'],
            [
                'scope' => '2',
                'description' => 'Grid electricity consumption.'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'FE Colombia (Interconectado)', 'emission_category_id' => $electricity->id],
            [
                'unit' => 'kWh',
                'factor_co2' => 0.126,
                'factor_ch4' => 0,
                'factor_n2o' => 0,
                'factor_total_co2e' => 0.126,
                'source_reference' => 'XM / UPME'
            ]
        );

        // 10. Scope 3 - Viajes Aéreos
        $flights = EmissionCategory::firstOrCreate(
            ['name' => 'Viajes Aéreos'],
            [
                'scope' => '3',
                'description' => 'Emissions from business air travel.'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'Vuelo Nacional (km)', 'emission_category_id' => $flights->id],
            [
                'unit' => 'km',
                'factor_total_co2e' => 0.255,
                'source_reference' => 'DEFRA 2023 - Domestic flights'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'Vuelo Internacional (km)', 'emission_category_id' => $flights->id],
            [
                'unit' => 'km',
                'factor_total_co2e' => 0.195,
                'source_reference' => 'DEFRA 2023 - International flights'
            ]
        );

        // 11. Scope 3 - Trabajo Remoto
        $remoteWork = EmissionCategory::firstOrCreate(
            ['name' => 'Trabajo Remoto'],
            [
                'scope' => '3',
                'description' => 'Emissions from employees working from home.'
            ]
        );

        EmissionFactor::firstOrCreate(
            ['name' => 'Empleado Remoto (día)', 'emission_category_id' => $remoteWork->id],
            [
                'unit' => 'día',
                'factor_total_co2e' => 2.5,
                'source_reference' => 'EcoAct 2020 - Home working emissions'
            ]
        );

        $this->command->info('✅ Emission factors created successfully');
    }
}
