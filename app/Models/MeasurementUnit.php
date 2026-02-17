<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeasurementUnit extends Model
{
    protected $fillable = ['name', 'symbol'];

    public function factors()
    {
        return $this->hasMany(EmissionFactor::class);
    }
}
