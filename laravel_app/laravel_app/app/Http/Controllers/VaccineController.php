<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;

class VaccineController extends Controller
{
    // ワクチン一覧・ガイド表示
    public function index()
    {
        $regularVaccines = Vaccine::where('type', 'regular')->get();
        $optionalVaccines = Vaccine::where('type', 'optional')->get();

        return view('vaccines.index', compact('regularVaccines', 'optionalVaccines'));
    }

    // ワクチン詳細表示
    public function show(Vaccine $vaccine)
    {
        return view('vaccines.show', compact('vaccine'));
    }
}