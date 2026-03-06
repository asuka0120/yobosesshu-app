<?php

namespace App\Http\Controllers;

use App\Models\MedicalInstitution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalInstitutionController extends Controller
{
    // 一覧表示
    public function index()
    {
        $institutions = Auth::user()->medicalInstitutions()->get();
        return view('medical_institutions.index', compact('institutions'));
    }

    // 登録フォーム表示
    public function create()
    {
        return view('medical_institutions.create');
    }

    // 登録処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'reception_hours' => 'nullable|string|max:100',
            'closed_days' => 'nullable|string',
            'memo' => 'nullable|string',
        ]);

        Auth::user()->medicalInstitutions()->create($request->all());

        return redirect()->route('medical_institutions.index')->with('success', '医療機関を登録しました！');
    }

    // 編集フォーム表示
    public function edit(MedicalInstitution $medicalInstitution)
    {
        if ($medicalInstitution->user_id !== Auth::id()) {
            abort(403);
        }
        return view('medical_institutions.edit', compact('medicalInstitution'));
    }

    // 更新処理
    public function update(Request $request, MedicalInstitution $medicalInstitution)
    {
        if ($medicalInstitution->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'reception_hours' => 'nullable|string|max:100',
            'closed_days' => 'nullable|string',
            'memo' => 'nullable|string',
        ]);

        $medicalInstitution->update($request->all());

        return redirect()->route('medical_institutions.index')->with('success', '更新しました！');
    }

    // 削除処理
    public function destroy(MedicalInstitution $medicalInstitution)
    {
        if ($medicalInstitution->user_id !== Auth::id()) {
            abort(403);
        }

        $medicalInstitution->delete();

        return redirect()->route('medical_institutions.index')->with('success', '削除しました！');
    }
}