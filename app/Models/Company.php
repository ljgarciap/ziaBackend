<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\LogsActivity;

class Company extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = ['name', 'nit', 'company_sector_id', 'logo_url'];

    public function sector()
    {
        return $this->belongsTo(CompanySector::class, 'company_sector_id');
    }

    public function periods()
    {
        return $this->hasMany(Period::class);
    }
}
