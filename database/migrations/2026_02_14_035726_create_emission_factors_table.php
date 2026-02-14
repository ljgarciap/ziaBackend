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
        Schema::dropIfExists('emission_factors'); // Drop if exists to recreate clean
        Schema::create('emission_factors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emission_category_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., 'Gasolina E10'
            $table->string('unit'); // e.g., 'Gal'
            
            // Detailed factors for high precision
            $table->decimal('factor_co2', 12, 6)->default(0);
            $table->decimal('factor_ch4', 12, 6)->default(0);
            $table->decimal('factor_n2o', 12, 6)->default(0);
            $table->decimal('factor_total_co2e', 12, 6)->default(0); // Pre-calculated total
            
            $table->text('source_reference')->nullable(); // e.g., 'IPCC 2006'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emission_factors');
    }
};
