<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculationFormula extends Model
{
    protected $fillable = ['name', 'expression', 'variables', 'description'];

    protected $casts = [
        'variables' => 'array',
    ];

    public function emissionFactors()
    {
        return $this->hasMany(EmissionFactor::class);
    }
}
