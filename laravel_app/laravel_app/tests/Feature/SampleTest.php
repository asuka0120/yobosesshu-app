<?php

namespace Tests\Feature;

use Tests\TestCase;

class SampleTest extends TestCase
{
    // テスト① 足し算が正しく計算できるか
    public function test_足し算が正しく計算できる()
    {
        $result = 1 + 1;
        $this->assertEquals(2, $result);
    }

    // テスト② 文字列が正しいか
    public function test_文字列が正しい()
    {
        $name = 'テストちゃん';
        $this->assertEquals('テストちゃん', $name);
    }

    // テスト③ 意図的に失敗させてみる
    public function test_これは失敗する()
    {
        $result = 1 + 1;
        $this->assertEquals(3, $result); // 2なのに3と期待→失敗！
    }
}