<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Period;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/companies",
     *     summary="List all companies",
     *     tags={"Companies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of companies",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Company::all());
    }

    /**
     * @OA\Get(
     *     path="/api/companies/{company}/periods",
     *     summary="Get periods for a specific company",
     *     tags={"Companies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="company",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of periods",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
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
