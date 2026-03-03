<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\VaccinationSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VaccinationScheduleController extends Controller
{
    // 接種スケジュール一覧表示
    public function index(Child $child)
    {
        // 自分の子どもかチェック
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $schedules = VaccinationSchedule::with('vaccine')
            ->where('child_id', $child->id)
            ->orderBy('scheduled_date')
            ->get();

        // 定期接種・任意接種に分類
        $regularSchedules = $schedules->filter(function ($schedule) {
            return $schedule->vaccine->type === 'regular';
        });

        $optionalSchedules = $schedules->filter(function ($schedule) {
            return $schedule->vaccine->type === 'optional';
        });

        return view('vaccination_schedules.index', compact('child', 'regularSchedules', 'optionalSchedules'));
    }
}
