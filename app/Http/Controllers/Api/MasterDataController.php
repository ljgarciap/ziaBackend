<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmissionCategory;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/dictionaries/factors",
     *     summary="Get all emission factors grouped by category",
     *     description="Use this to populate dropdowns in the frontend. Includes nested factors for each category.",
     *     tags={"Master Data"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Grouped categories and factors",
     *         @OA\JsonContent(type="array", @OA\Items(type="object"))
     *     )
     * )
     */
    public function emissionFactors()
    {
        $categories = EmissionCategory::with('factors')->get();
        return response()->json($categories);
    }
}
