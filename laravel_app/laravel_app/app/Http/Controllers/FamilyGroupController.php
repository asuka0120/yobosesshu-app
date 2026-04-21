<?php

namespace App\Http\Controllers;

use App\Models\FamilyGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyGroupController extends Controller
{
    // 家族グループ管理画面
    public function index()
    {
        $ownedGroup = Auth::user()->ownedFamilyGroup;
        $joinedGroups = Auth::user()->familyGroups;

        return view('family_groups.index', compact('ownedGroup', 'joinedGroups'));
    }

    // グループ作成
    public function store()
    {
        // すでにグループを持っている場合は作成しない
        if (Auth::user()->ownedFamilyGroup) {
            return redirect()->route('family_groups.index')->with('error', 'すでにグループを作成しています。');
        }

        FamilyGroup::create([
            'owner_id' => Auth::id(),
            'invite_code' => FamilyGroup::generateInviteCode(),
        ]);

        return redirect()->route('family_groups.index')->with('success', 'グループを作成しました！');
    }

    // 招待コードで参加
    public function join(Request $request)
    {
        $request->validate([
            'invite_code' => 'required|string',
        ]);

        $group = FamilyGroup::where('invite_code', $request->invite_code)->first();

        if (!$group) {
            return redirect()->route('family_groups.index')->with('error', '招待コードが正しくありません。');
        }

        // 自分のグループには参加できない
        if ($group->owner_id === Auth::id()) {
            return redirect()->route('family_groups.index')->with('error', '自分のグループには参加できません。');
        }

        // すでに参加している場合
        if ($group->members()->where('user_id', Auth::id())->exists()) {
    return redirect()->route('family_groups.index')->with('error', 'すでに参加しています。');
        }

        $group->members()->attach(Auth::id());

        return redirect()->route('family_groups.index')->with('success', 'グループに参加しました！');
    }

    // メンバー削除
    public function removeMember($groupId, $userId)
    {
        $group = FamilyGroup::findOrFail($groupId);

        if ($group->owner_id !== Auth::id()) {
            abort(403);
        }

        $group->members()->detach($userId);

        return redirect()->route('family_groups.index')->with('success', 'メンバーを削除しました！');
    }

    // グループ削除
    public function destroy($id)
    {
        $group = FamilyGroup::findOrFail($id);

        if ($group->owner_id !== Auth::id()) {
            abort(403);
        }

        $group->delete();

        return redirect()->route('family_groups.index')->with('success', 'グループを削除しました！');
    }
}