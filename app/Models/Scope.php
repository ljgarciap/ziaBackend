<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    protected $fillable = ['name', 'description', 'documentation_text'];

    public function categories()
    {
        return $this->hasMany(EmissionCategory::class);
    }
}
