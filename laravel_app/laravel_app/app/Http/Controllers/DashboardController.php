<?php

namespace App\Http\Controllers;

use App\Models\VaccinationSchedule;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $children = Auth::user()->children()->get();

        // 各子どもの次回接種予定を取得
        $upcomingSchedules = VaccinationSchedule::with(['child', 'vaccine'])
            ->whereHas('child', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('status', 'pending')
            ->orderBy('scheduled_date')
            ->take(10)
            ->get();

        // 接種期限が近いもの（30日以内）
        $alertSchedules = VaccinationSchedule::with(['child', 'vaccine'])
            ->whereHas('child', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('status', 'pending')
            ->where('scheduled_date', '<=', now()->addDays(30))
            ->orderBy('scheduled_date')
            ->get();

        return view('dashboard', compact('children', 'upcomingSchedules', 'alertSchedules'));
    }
}