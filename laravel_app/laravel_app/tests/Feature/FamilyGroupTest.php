<?php

namespace Tests\Feature;

use App\Models\FamilyGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FamilyGroupTest extends TestCase
{
    use RefreshDatabase;

    // テスト① 正しい招待コードでグループに参加できるか
    public function test_正しい招待コードでグループに参加できる()
    {
        // ① 準備：オーナーとメンバーを作成する
        $owner  = User::factory()->create();
        $member = User::factory()->create();
        $group  = FamilyGroup::factory()->create([
            'owner_id' => $owner->id,
        ]);

        // ② 実行：招待コードで参加する
        $response = $this->actingAs($member)->post('/family/join', [
            'invite_code' => $group->invite_code,
        ]);

        // ③ 確認：参加できたか確認する
        $response->assertRedirect(route('family_groups.index'));
        $this->assertCount(1, $group->fresh()->members);
    }

    // テスト② 同じグループに重複参加できないか
    public function test_同じグループに重複参加できない()
    {
        // ① 準備：オーナーとメンバーを作成する
        $owner  = User::factory()->create();
        $member = User::factory()->create();
        $group  = FamilyGroup::factory()->create([
            'owner_id' => $owner->id,
        ]);

        // ② 実行：同じ招待コードで2回参加を試みる
        $this->actingAs($member)->post('/family/join', [
            'invite_code' => $group->invite_code,
        ]);
        $response = $this->actingAs($member)->post('/family/join', [
            'invite_code' => $group->invite_code,
        ]);

        // ③ 確認：2回目は「すでに参加しています。」エラーが出るか確認する
        $response->assertSessionHas('error', 'すでに参加しています。');
        $this->assertCount(1, $group->fresh()->members);
    }
}