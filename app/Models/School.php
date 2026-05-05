<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'is_pc', 'region_id', 'slug'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function levels()
    {
        return $this->belongsToMany(Level::class);
    }
}
