<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Period;
use App\Models\User;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 3 Test Companies
        $companies = [
            ['name' => 'Tech Solutions SAS', 'nit' => '900123456', 'sector' => 'Technology'],
            ['name' => 'Green Energy Corp', 'nit' => '900654321', 'sector' => 'Energy'],
            ['name' => 'Constructora Perez', 'nit' => '900987654', 'sector' => 'Construction'],
        ];

        foreach ($companies as $compData) {
            $company = Company::create($compData);
            
            // Period 2024
            Period::create([
                'company_id' => $company->id,
                'year' => 2024,
                'status' => 'active'
            ]);
            
            // Period 2023 (Closed)
            Period::create([
                'company_id' => $company->id,
                'year' => 2023,
                'status' => 'closed'
            ]);
        }
        
        // Link existing users to companies? No, user table doesn't have company_id yet.
        // Assuming user management is separate or superadmin for now.
    }
}
