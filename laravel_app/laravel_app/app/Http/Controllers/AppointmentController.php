<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Child;
use App\Models\MedicalInstitution;
use App\Models\VaccinationSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // 予約一覧表示
    public function index(Child $child)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $appointments = Appointment::with(['medicalInstitution', 'vaccinationSchedule.vaccine'])
            ->where('child_id', $child->id)
            ->orderBy('appointment_date')
            ->get();

        return view('appointments.index', compact('child', 'appointments'));
    }

    // 登録フォーム表示
    public function create(Child $child)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $institutions = Auth::user()->medicalInstitutions()->get();
        $schedules = VaccinationSchedule::with('vaccine')
            ->where('child_id', $child->id)
            ->where('status', 'pending')
            ->get();

        return view('appointments.create', compact('child', 'institutions', 'schedules'));
    }

    // 登録処理
    public function store(Request $request, Child $child)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'medical_institution_id' => 'required|exists:medical_institutions,id',
            'vaccination_schedule_id' => 'nullable|exists:vaccination_schedules,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'nullable|date_format:H:i',
            'memo' => 'nullable|string',
        ]);

        Appointment::create([
            'child_id' => $child->id,
            'medical_institution_id' => $request->medical_institution_id,
            'vaccination_schedule_id' => $request->vaccination_schedule_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'memo' => $request->memo,
        ]);

        return redirect()->route('appointments.index', $child)->with('success', '予約を登録しました！');
    }

    // 削除処理
    public function destroy(Child $child, Appointment $appointment)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $appointment->delete();

        return redirect()->route('appointments.index', $child)->with('success', '予約を削除しました！');
    }
}
