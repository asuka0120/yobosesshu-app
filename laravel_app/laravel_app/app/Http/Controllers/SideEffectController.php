<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\SideEffect;
use App\Models\VaccinationSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SideEffectController extends Controller
{
    // 副反応一覧表示
    public function index(Child $child)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $sideEffects = SideEffect::with('vaccinationSchedule.vaccine')
            ->where('child_id', $child->id)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('side_effects.index', compact('child', 'sideEffects'));
    }

    // 登録フォーム表示
    public function create(Child $child)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $schedules = VaccinationSchedule::with('vaccine')
            ->where('child_id', $child->id)
            ->where('status', 'completed')
            ->get();

        return view('side_effects.create', compact('child', 'schedules'));
    }

    // 登録処理
    public function store(Request $request, Child $child)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'vaccination_schedule_id' => 'required|exists:vaccination_schedules,id',
            'symptom' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'memo' => 'nullable|string',
        ]);

        SideEffect::create([
            'child_id' => $child->id,
            'vaccination_schedule_id' => $request->vaccination_schedule_id,
            'symptom' => $request->symptom,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'memo' => $request->memo,
        ]);

        return redirect()->route('side_effects.index', $child)->with('success', '副反応を記録しました！');
    }

    // 削除処理
    public function destroy(Child $child, SideEffect $sideEffect)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $sideEffect->delete();

        return redirect()->route('side_effects.index', $child)->with('success', '削除しました！');
    }
}
