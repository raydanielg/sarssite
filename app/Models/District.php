<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['region_id', 'name', 'slug'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }

    public function resultTitles()
    {
        return $this->hasMany(ResultTitle::class);
    }
}
