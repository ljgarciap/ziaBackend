<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminCompanyController extends Controller
{
    public function index()
    {
        return response()->json(Company::withTrashed()->with('periods')->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nit' => 'nullable|string|max:20',
            'sector' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $company = Company::create($request->all());
        return response()->json($company, 201);
    }

    public function update(Request $request, Company $company)
    {
        $company->update($request->all());
        return response()->json($company);
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json(null, 204);
    }

    // Period Management
    public function addPeriod(Request $request, Company $company)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|integer',
            'status' => 'required|string|in:open,closed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $period = $company->periods()->create($request->all());
        return response()->json($period, 201);
    }

    public function updatePeriod(Request $request, Period $period)
    {
        $period->update($request->all());
        return response()->json($period);
    }

    public function deletePeriod(Period $period)
    {
        $period->delete();
        return response()->json(null, 204);
    }
}
