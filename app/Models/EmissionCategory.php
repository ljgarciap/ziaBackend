<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmissionCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'scope', 'description'];

    public function factors()
    {
        return $this->hasMany(EmissionFactor::class);
    }
}
