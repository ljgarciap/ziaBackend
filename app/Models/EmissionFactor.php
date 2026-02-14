<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmissionFactor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'emission_category_id',
        'name',
        'unit',
        'factor_co2',
        'factor_ch4',
        'factor_n2o',
        'factor_total_co2e',
        'source_reference'
    ];

    public function category()
    {
        return $this->belongsTo(EmissionCategory::class, 'emission_category_id');
    }

    public function emissions()
    {
        return $this->hasMany(CarbonEmission::class);
    }
}
