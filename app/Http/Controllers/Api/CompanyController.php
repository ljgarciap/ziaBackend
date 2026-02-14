<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Period;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * List all companies (for selection).
     */
    public function index()
    {
        return response()->json(Company::all());
    }

    /**
     * Get periods for a specific company.
     */
    public function periods($companyContext)
    {
        // $companyContext can be ID or even NIT if needed. Assuming ID for now.
        $periods = Period::where('company_id', $companyContext)
                        ->orderBy('year', 'desc')
                        ->get();
        return response()->json($periods);
    }
}
