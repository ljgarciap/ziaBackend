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
            if (!Schema::hasColumn('emission_factors', 'calculation_formula_id')) {
                $table->foreignId('calculation_formula_id')->after('emission_category_id')->nullable()->constrained('calculation_formulas')->nullOnDelete();
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emission_factors', function (Blueprint $table) {
            $table->dropForeign(['calculation_formula_id']);
            $table->dropColumn(['calculation_formula_id', 'uncertainty_lower', 'uncertainty_upper', 'uncertainty_distribution']);
        });
    }
};
