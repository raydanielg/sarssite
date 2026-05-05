<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultSummary extends Model
{
    use HasFactory;

    protected $fillable = ['result_title_id', 'name', 'file_path', 'status'];

    public function resultTitle()
    {
        return $this->belongsTo(ResultTitle::class);
    }
}
