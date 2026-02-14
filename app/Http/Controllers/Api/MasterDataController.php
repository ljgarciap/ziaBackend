<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmissionCategory;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    /**
     * Get all emission factors grouped by category.
     * Use this to populate dropdowns in the frontend.
     */
    public function emissionFactors()
    {
        $categories = EmissionCategory::with('factors')->get();
        return response()->json($categories);
    }
}
