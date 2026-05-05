<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'result_title_id',
        'school_id',
        'description',
        'file_path',
        'status'
    ];

    public function resultTitle()
    {
        return $this->belongsTo(ResultTitle::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
