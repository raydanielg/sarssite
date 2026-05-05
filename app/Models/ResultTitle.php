<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultTitle extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'year_id', 'level_id', 'region_id', 'slug'];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
