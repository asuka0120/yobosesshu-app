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

    'attributes' => [
        'nickname'   => 'ニックネーム',
        'birth_date' => '生年月日',
        'email'      => 'メールアドレス',
        'password'   => 'パスワード',
    ],
];