<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotherChildPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'file_path',
        'title',
        'memo',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}