<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'year', 'status'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function emissions()
    {
        return $this->hasMany(CarbonEmission::class);
    }
}
