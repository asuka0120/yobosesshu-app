<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChildTest extends TestCase
{
    use RefreshDatabase;

    // テスト① 子どもを正常に登録できるか
    public function test_子どもを正常に登録できる()
    {
        // ① 準備：テスト用のユーザーを作成する
        $user = User::factory()->create();

        // ② 実行：子ども登録を試みる
        $response = $this->actingAs($user)->post('/children', [
            'nickname'   => 'テストちゃん',
            'birth_date' => '2023-01-01', // ← birth_dateに修正
        ]);

        // ③ 確認：登録できたか確認する
        $response->assertRedirect(route('children.index')); // ← route名に修正
        $this->assertDatabaseHas('children', [
            'nickname' => 'テストちゃん',
        ]);
    }

    // テスト② 必須項目未入力でバリデーションエラーになるか
    public function test_必須項目未入力でバリデーションエラーになる()
    {
        // ① 準備：テスト用のユーザーを作成する
        $user = User::factory()->create();

        // ② 実行：何も入力せずに登録を試みる
        $response = $this->actingAs($user)->post('/children', []);

        // ③ 確認：バリデーションエラーが出るか確認する
        $response->assertSessionHasErrors(['nickname', 'birth_date']); // ← birth_dateに修正
    }
}