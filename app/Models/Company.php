<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'nit', 'sector_id', 'sector', 'logo_url'];

    public function sectorInfo()
    {
        return $this->belongsTo(CompanySector::class, 'sector_id');
    }

    public function periods()
    {
        return $this->hasMany(Period::class);
    }
}
