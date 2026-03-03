<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    // 一覧表示
    public function index()
    {
        $children = Auth::user()->children()->get();
        return view('children.index', compact('children'));
    }

    // 登録フォーム表示
    public function create()
    {
        return view('children.create');
    }

    // 登録処理
    public function store(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:50',
            'birth_date' => 'required|date',
        ]);

        Auth::user()->children()->create($request->only('nickname', 'birth_date'));

        return redirect()->route('children.index')->with('success', 'お子さんを登録しました！');
    }

    // 編集フォーム表示
    public function edit(Child $child)
    {
        return view('children.edit', compact('child'));
    }

    // 更新処理
    public function update(Request $request, Child $child)
    {
        $request->validate([
            'nickname' => 'required|string|max:50',
            'birth_date' => 'required|date',
        ]);

        $child->update($request->only('nickname', 'birth_date'));

        return redirect()->route('children.index')->with('success', '更新しました！');
    }

    // 削除処理
    public function destroy(Child $child)
    {
        $child->delete();
        return redirect()->route('children.index')->with('success', 'ゴミ箱に移動しました！');
    }
}