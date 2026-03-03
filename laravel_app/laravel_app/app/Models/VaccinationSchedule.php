<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VaccinationSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'child_id',
        'vaccine_id',
        'status',
        'scheduled_date',
        'vaccinated_date',
        'memo',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'vaccinated_date' => 'date',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }
}