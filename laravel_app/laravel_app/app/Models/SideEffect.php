<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SideEffect extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'vaccination_schedule_id',
        'symptom',
        'start_date',
        'end_date',
        'memo',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function vaccinationSchedule()
    {
        return $this->belongsTo(VaccinationSchedule::class);
    }
}
