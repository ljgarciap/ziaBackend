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
        $companyId = (int)$request->query('company_id', 1);
        $periodId = (int)$request->query('period_id', 1);

        // Generate deterministic pseudo-random numbers based on IDs
        $seed = ($companyId * 100) + $periodId;
        srand($seed);

        $baseHuella = 500 + ($seed % 1000);
        $scope1 = $baseHuella * 0.2 + (rand(0, 50));
        $scope2 = $baseHuella * 0.05 + (rand(0, 10));
        $scope3 = $baseHuella - $scope1 - $scope2;

        return response()->json([
            'huella_total' => round($baseHuella, 2),
            'neutralizados' => ($seed % 5 === 0) ? round($baseHuella * 0.1, 2) : 0,
            'alcances' => [
                'scope_1' => [
                    'total' => round($scope1, 2),
                    'percentage' => round(($scope1 / $baseHuella) * 100),
                    'neutralizado' => 0
                ],
                'scope_2' => [
                    'total' => round($scope2, 2),
                    'percentage' => round(($scope2 / $baseHuella) * 100),
                    'neutralizado' => 0
                ],
                'scope_3' => [
                    'total' => round($scope3, 2),
                    'percentage' => round(($scope3 / $baseHuella) * 100),
                    'neutralizado' => 0
                ]
            ],
            'chart_data' => [
                'donut' => [
                    ['label' => 'Alcance 1', 'value' => round($scope1, 2), 'color' => '#1a237e'],
                    ['label' => 'Alcance 2', 'value' => round($scope2, 2), 'color' => '#00897b'],
                    ['label' => 'Alcance 3', 'value' => round($scope3, 2), 'color' => '#f59e0b']
                ],
                'details' => [
                    ['scope' => 1, 'source' => 'Vehículos propios', 'total' => round($scope1 * 0.6, 2), 'percentage' => round(($scope1 * 0.6 / $baseHuella) * 100, 2)],
                    ['scope' => 1, 'source' => 'Gas natural', 'total' => round($scope1 * 0.4, 2), 'percentage' => round(($scope1 * 0.4 / $baseHuella) * 100, 2)],
                    ['scope' => 2, 'source' => 'Energía Eléctrica', 'total' => round($scope2, 2), 'percentage' => round(($scope2 / $baseHuella) * 100, 2)],
                    ['scope' => 3, 'source' => 'Viajes', 'total' => round($scope3 * 0.5, 2), 'percentage' => round(($scope3 * 0.5 / $baseHuella) * 100, 2)],
                    ['scope' => 3, 'source' => 'Residuos', 'total' => round($scope3 * 0.5, 2), 'percentage' => round(($scope3 * 0.5 / $baseHuella) * 100, 2)],
                ]
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
