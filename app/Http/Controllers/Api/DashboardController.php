<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Period;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function summary(Request $request)
    {
        $companyId = $request->query('company_id');
        $periodId = $request->query('period_id');

        if (!$companyId || !$periodId) {
            return response()->json(['error' => 'Company and Period are required'], 400);
        }

        // Fetch all emissions for the given period
        // We join with factors and categories to get names and scopes
        $emissions = \App\Models\CarbonEmission::where('period_id', $periodId)
            ->with(['factor.category'])
            ->get();

        $huellaTotal = $emissions->sum('calculated_co2e');
        
        // Group by Scope
        $scopes = [
            1 => ['total' => 0, 'label' => 'Alcance 1', 'color' => '#1a237e'],
            2 => ['total' => 0, 'label' => 'Alcance 2', 'color' => '#00897b'],
            3 => ['total' => 0, 'label' => 'Alcance 3', 'color' => '#f59e0b'],
        ];

        $details = [];

        foreach ($emissions as $emission) {
            $scope = $emission->factor->category->scope ?? 3;
            if (isset($scopes[$scope])) {
                $scopes[$scope]['total'] += $emission->calculated_co2e;
            }

            $details[] = [
                'scope' => $scope,
                'source' => $emission->factor->name,
                'total' => round($emission->calculated_co2e, 4),
                'percentage' => $huellaTotal > 0 ? round(($emission->calculated_co2e / $huellaTotal) * 100, 2) : 0
            ];
        }

        // Prepare response structure
        $alcancesRes = [];
        $donutData = [];
        foreach ($scopes as $sNum => $sInfo) {
            $alcancesRes['scope_' . $sNum] = [
                'total' => round($sInfo['total'], 2),
                'percentage' => $huellaTotal > 0 ? round(($sInfo['total'] / $huellaTotal) * 100) : 0,
                'neutralizado' => 0 // Future field
            ];
            $donutData[] = [
                'label' => $sInfo['label'],
                'value' => round($sInfo['total'], 2),
                'color' => $sInfo['color']
            ];
        }

        // Equivalency Logic: ~0.5 tCO2e is what one person consumes annually in energy (typical factor)
        $eqFactor = 0.5; 
        $eqValue = $huellaTotal > 0 ? round($huellaTotal / $eqFactor, 1) : 0;

        return response()->json([
            'huella_total' => round($huellaTotal, 2),
            'neutralizados' => 0, // Placeholder
            'alcances' => $alcancesRes,
            'equivalency' => [
                'value' => $eqValue,
                'label' => 'Personas consumiendo energía eléctrica anualmente'
            ],
            'chart_data' => [
                'donut' => $donutData,
                'details' => collect($details)->sortByDesc('total')->values()->all()
            ]
        ]);
    }

    public function trends(Request $request)
    {
        $companyId = (int)$request->query('company_id', 1);
        $seed = $companyId * 10;
        srand($seed);

        $generateData = function($count, $min, $max) {
            $data = [];
            for($i=0; $i<$count; $i++) $data[] = rand($min, $max);
            return $data;
        };

        return response()->json([
            'revenue_trend' => [
                'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct'],
                'datasets' => [
                    ['label' => 'Actual', 'data' => $generateData(10, 300, 600)],
                    ['label' => 'Previo', 'data' => $generateData(10, 200, 500)],
                ]
            ],
            'sales_quantity' => [
                'labels' => ['Cat A', 'Cat B', 'Cat C', 'Cat D'],
                'datasets' => [
                    ['label' => 'Volumen', 'data' => $generateData(4, 40, 100)],
                ]
            ]
        ]);
    }
}
