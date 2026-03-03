<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'reason',
        'recommended_months',
    ];

    public function vaccinationSchedules()
    {
        return $this->hasMany(VaccinationSchedule::class);
    }
}