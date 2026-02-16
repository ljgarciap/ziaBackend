<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('emission_factors', function (Blueprint $table) {
            if (!Schema::hasColumn('emission_factors', 'factor_nf3')) {
                $table->decimal('factor_nf3', 15, 8)->nullable()->default(0)->after('factor_n2o');
            }
            if (!Schema::hasColumn('emission_factors', 'factor_sf6')) {
                $table->decimal('factor_sf6', 15, 8)->nullable()->default(0)->after('factor_nf3');
            }
            if (!Schema::hasColumn('emission_factors', 'calculation_formula_id')) {
                $table->foreignId('calculation_formula_id')->nullable()->after('emission_category_id')->constrained('calculation_formulas')->nullOnDelete();
            }
            if (!Schema::hasColumn('emission_factors', 'uncertainty_lower')) {
                $table->decimal('uncertainty_lower', 10, 5)->nullable()->after('factor_total_co2e');
            }
            if (!Schema::hasColumn('emission_factors', 'uncertainty_upper')) {
                $table->decimal('uncertainty_upper', 10, 5)->nullable()->after('uncertainty_lower');
            }
            if (!Schema::hasColumn('emission_factors', 'uncertainty_distribution')) {
                $table->string('uncertainty_distribution')->nullable()->default('normal')->after('uncertainty_upper');
            }
        });

        Schema::table('carbon_emissions', function (Blueprint $table) {
            if (!Schema::hasColumn('carbon_emissions', 'emissions_co2')) {
                $table->decimal('emissions_co2', 15, 8)->nullable()->default(0)->after('quantity');
            }
            if (!Schema::hasColumn('carbon_emissions', 'emissions_ch4')) {
                $table->decimal('emissions_ch4', 15, 8)->nullable()->default(0)->after('emissions_co2');
            }
            if (!Schema::hasColumn('carbon_emissions', 'emissions_n2o')) {
                $table->decimal('emissions_n2o', 15, 8)->nullable()->default(0)->after('emissions_ch4');
            }
            if (!Schema::hasColumn('carbon_emissions', 'emissions_nf3')) {
                $table->decimal('emissions_nf3', 15, 8)->nullable()->default(0)->after('emissions_n2o');
            }
            if (!Schema::hasColumn('carbon_emissions', 'emissions_sf6')) {
                $table->decimal('emissions_sf6', 15, 8)->nullable()->default(0)->after('emissions_nf3');
            }
            if (!Schema::hasColumn('carbon_emissions', 'uncertainty_result')) {
                $table->decimal('uncertainty_result', 12, 6)->nullable()->after('calculated_co2e');
            }
            if (!Schema::hasColumn('carbon_emissions', 'activity_data_total')) {
                $table->decimal('activity_data_total', 15, 8)->nullable()->after('uncertainty_result');
            }
            if (!Schema::hasColumn('carbon_emissions', 'activity_data_stdev')) {
                $table->decimal('activity_data_stdev', 15, 8)->nullable()->after('activity_data_total');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emission_factors', function (Blueprint $table) {
            $table->dropColumn([
                'factor_nf3', 'factor_sf6', 'calculation_formula_id', 
                'uncertainty_lower', 'uncertainty_upper', 'uncertainty_distribution'
            ]);
        });

        Schema::table('carbon_emissions', function (Blueprint $table) {
            $table->dropColumn([
                'emissions_co2', 'emissions_ch4', 'emissions_n2o', 
                'emissions_nf3', 'emissions_sf6', 
                'uncertainty_result', 'activity_data_total', 'activity_data_stdev'
            ]);
        });
    }
};
