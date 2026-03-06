<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\MotherChildPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MotherChildPhotoController extends Controller
{
    // 写真一覧表示
    public function index(Child $child)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $photos = MotherChildPhoto::where('child_id', $child->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mother_child_photos.index', compact('child', 'photos'));
    }

    // アップロードフォーム表示
    public function create(Child $child)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        return view('mother_child_photos.create', compact('child'));
    }

    // アップロード処理
    public function store(Request $request, Child $child)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'title' => 'nullable|string|max:100',
            'memo' => 'nullable|string',
        ]);

        // 写真を保存
        $path = $request->file('photo')->store('mother_child_photos', 'public');

        MotherChildPhoto::create([
            'child_id' => $child->id,
            'file_path' => $path,
            'title' => $request->title,
            'memo' => $request->memo,
        ]);

        return redirect()->route('mother_child_photos.index', $child)->with('success', '写真を保存しました！');
    }

    // 削除処理
    public function destroy(Child $child, MotherChildPhoto $motherChildPhoto)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        // ファイルを削除
        Storage::disk('public')->delete($motherChildPhoto->file_path);
        $motherChildPhoto->delete();

        return redirect()->route('mother_child_photos.index', $child)->with('success', '写真を削除しました！');
    }
}