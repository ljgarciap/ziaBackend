<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonEmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'emission_factor_id',
        'quantity',
        'calculated_co2e',
        'notes'
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function factor()
    {
        return $this->belongsTo(EmissionFactor::class, 'emission_factor_id');
    }
}
