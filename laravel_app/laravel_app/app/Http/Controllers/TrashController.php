<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Support\Facades\Auth;

class TrashController extends Controller
{
    // ゴミ箱一覧表示
    public function index()
    {
        $trashedChildren = Child::onlyTrashed()
            ->where('user_id', Auth::id())
            ->get();

        return view('trash.index', compact('trashedChildren'));
    }

    // 復元
    public function restore($id)
    {
        $child = Child::onlyTrashed()
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $child->restore();

        return redirect()->route('trash.index')->with('success', '復元しました！');
    }

    // 完全削除
    public function forceDelete($id)
    {
        $child = Child::onlyTrashed()
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $child->forceDelete();

        return redirect()->route('trash.index')->with('success', '完全に削除しました！');
    }
}