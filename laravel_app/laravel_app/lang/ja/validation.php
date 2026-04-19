<?php

return [
    'required' => ':attributeは必須です。',
    'string'   => ':attributeは文字列で入力してください。',
    'max'      => [
        'string' => ':attributeは:max文字以内で入力してください。',
    ],
    'date'     => ':attributeは正しい日付形式で入力してください。',
    'email'    => ':attributeは有効なメールアドレスで入力してください。',
    'unique'   => ':attributeはすでに使用されています。',
    'confirmed'=> ':attributeと確認用が一致しません。',
    'after_or_equal' => ':attributeは:date以降の日付を入力してください。',

    'attributes' => [
        'nickname'   => 'ニックネーム',
        'birth_date' => '生年月日',
        'email'      => 'メールアドレス',
        'password'   => 'パスワード',
        'vaccinated_date' => '接種日',  // ← これを追加
        'vaccination_schedule_id' => 'ワクチン名',    // ← 追加
        'symptom'   => '症状',    // ← 追加
        'start_date'  => '開始日',   // ← 追加
        'end_date' => '終了日',
        'name' => '医療機関名',
        'medical_institution_id' => '医療機関',
        'appointment_date'  => '予約日',
    ],
];