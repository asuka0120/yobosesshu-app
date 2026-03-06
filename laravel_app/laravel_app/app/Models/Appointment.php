<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'medical_institution_id',
        'vaccination_schedule_id',
        'appointment_date',
        'appointment_time',
        'memo',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function medicalInstitution()
    {
        return $this->belongsTo(MedicalInstitution::class);
    }

    public function vaccinationSchedule()
    {
        return $this->belongsTo(VaccinationSchedule::class);
    }
}