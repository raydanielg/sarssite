<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function resultTypes()
    {
        return $this->belongsToMany(ResultType::class, 'result_type_levels');
    }
}
