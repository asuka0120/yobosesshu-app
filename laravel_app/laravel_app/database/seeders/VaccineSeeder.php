<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vaccine;

class VaccineSeeder extends Seeder
{
    public function run(): void
    {
        $vaccines = [
            // 定期接種
            [
                'name' => 'B型肝炎',
                'type' => 'regular',
                'description' => 'B型肝炎ウイルスの感染を予防するワクチンです。',
                'reason' => 'B型肝炎は肝硬変や肝がんの原因になることがあります。',
                'recommended_months' => 2,
            ],
            [
                'name' => 'ロタウイルス',
                'type' => 'regular',
                'description' => 'ロタウイルスによる胃腸炎を予防するワクチンです。',
                'reason' => '乳幼児の重症胃腸炎の主な原因ウイルスです。',
                'recommended_months' => 2,
            ],
            [
                'name' => 'ヒブ（Hib）',
                'type' => 'regular',
                'description' => 'ヒブ（インフルエンザ菌b型）による髄膜炎などを予防します。',
                'reason' => '乳幼児の細菌性髄膜炎の主な原因菌です。',
                'recommended_months' => 2,
            ],
            [
                'name' => '小児用肺炎球菌',
                'type' => 'regular',
                'description' => '肺炎球菌による髄膜炎・肺炎などを予防します。',
                'reason' => '乳幼児の細菌性髄膜炎の原因になります。',
                'recommended_months' => 2,
            ],
            [
                'name' => 'DPT-IPV（四種混合）',
                'type' => 'regular',
                'description' => 'ジフテリア・百日咳・破傷風・ポリオを予防します。',
                'reason' => '4つの重篤な感染症をまとめて予防できます。',
                'recommended_months' => 3,
            ],
            [
                'name' => 'BCG',
                'type' => 'regular',
                'description' => '結核を予防するワクチンです。',
                'reason' => '乳幼児の重症結核（結核性髄膜炎など）を予防します。',
                'recommended_months' => 5,
            ],
            [
                'name' => 'MR（麻しん・風しん混合）',
                'type' => 'regular',
                'description' => '麻しん（はしか）と風しんを予防します。',
                'reason' => '麻しんは重症化しやすく、風しんは妊婦への感染で先天性風しん症候群を引き起こします。',
                'recommended_months' => 12,
            ],
            [
                'name' => '水痘（水ぼうそう）',
                'type' => 'regular',
                'description' => '水痘ウイルスによる水ぼうそうを予防します。',
                'reason' => '感染力が非常に強く、重症化することがあります。',
                'recommended_months' => 12,
            ],
            [
                'name' => '日本脳炎',
                'type' => 'regular',
                'description' => '日本脳炎ウイルスによる脳炎を予防します。',
                'reason' => '致死率が高く、後遺症が残ることがあります。',
                'recommended_months' => 36,
            ],
            // 任意接種
            [
                'name' => 'おたふくかぜ',
                'type' => 'optional',
                'description' => 'ムンプスウイルスによるおたふくかぜを予防します。',
                'reason' => '難聴などの重篤な合併症を引き起こすことがあります。',
                'recommended_months' => 12,
            ],
            [
                'name' => 'インフルエンザ',
                'type' => 'optional',
                'description' => 'インフルエンザウイルスの感染を予防します。',
                'reason' => '乳幼児は重症化しやすいため接種が推奨されます。',
                'recommended_months' => 6,
            ],
        ];

        foreach ($vaccines as $vaccine) {
            \App\Models\Vaccine::create($vaccine);
        }
    }
}