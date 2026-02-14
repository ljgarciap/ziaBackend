<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Admin & SuperAdmin Routes
    Route::middleware(['role:superadmin,admin'])->prefix('admin')->group(function () {
        // Companies & Periods Management
        Route::get('/companies', [\App\Http\Controllers\Api\Admin\AdminCompanyController::class, 'index']);
        Route::post('/companies', [\App\Http\Controllers\Api\Admin\AdminCompanyController::class, 'store']);
        Route::put('/companies/{company}', [\App\Http\Controllers\Api\Admin\AdminCompanyController::class, 'update']);
        Route::delete('/companies/{company}', [\App\Http\Controllers\Api\Admin\AdminCompanyController::class, 'destroy']);
        Route::post('/companies/{company}/periods', [\App\Http\Controllers\Api\Admin\AdminCompanyController::class, 'addPeriod']);
        Route::put('/periods/{period}', [\App\Http\Controllers\Api\Admin\AdminCompanyController::class, 'updatePeriod']);
        Route::delete('/periods/{period}', [\App\Http\Controllers\Api\Admin\AdminCompanyController::class, 'deletePeriod']);

        // Users Management
        Route::get('/users', [\App\Http\Controllers\Api\Admin\AdminUserController::class, 'index']);
        Route::post('/users', [\App\Http\Controllers\Api\Admin\AdminUserController::class, 'store']);
        Route::put('/users/{user}', [\App\Http\Controllers\Api\Admin\AdminUserController::class, 'update']);
        Route::delete('/users/{user}', [\App\Http\Controllers\Api\Admin\AdminUserController::class, 'destroy']);

        // Master Data (Categories & Factors) - Restricted to SuperAdmin
        Route::middleware(['role:superadmin'])->group(function () {
            Route::get('/categories', [\App\Http\Controllers\Api\Admin\AdminMasterDataController::class, 'indexCategories']);
            Route::post('/categories', [\App\Http\Controllers\Api\Admin\AdminMasterDataController::class, 'storeCategory']);
            Route::delete('/categories/{category}', [\App\Http\Controllers\Api\Admin\AdminMasterDataController::class, 'deleteCategory']);
            Route::post('/factors', [\App\Http\Controllers\Api\Admin\AdminMasterDataController::class, 'storeFactor']);
            Route::put('/factors/{factor}', [\App\Http\Controllers\Api\Admin\AdminMasterDataController::class, 'updateFactor']);
            Route::delete('/factors/{factor}', [\App\Http\Controllers\Api\Admin\AdminMasterDataController::class, 'deleteFactor']);
        });
    });

    // Public Dictionaries (Master Data for usage in forms/dashboards)
    Route::get('/companies', [App\Http\Controllers\Api\CompanyController::class, 'index']);
    Route::get('/companies/{id}/periods', [App\Http\Controllers\Api\CompanyController::class, 'periods']);
    Route::get('/dictionaries/factors', [App\Http\Controllers\Api\MasterDataController::class, 'emissionFactors']);

    // Dashboard Routes
    Route::get('/dashboard/summary', [App\Http\Controllers\Api\DashboardController::class, 'summary']);
    Route::get('/dashboard/trends', [App\Http\Controllers\Api\DashboardController::class, 'trends']);
});
