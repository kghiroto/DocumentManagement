<?php
return [
	'row_count_per_page' => 1000,
    'unit_options' => [
        '0' => '式',
        '1' => 'm',
        '2' => 'm2',
        '3' => 'm3',
        '4' => '組',
        '5' => '台',
        '6' => '個',
    ],
    'tax_rate' => 0.10,
    // 消費税10%対応方法
    // 0.1 に変更し、過去の分を編集できないようにする
    // 過去の見積もりは、tax_rate を使っている箇所をすべて調査し、見積書の日付で消費税を使い分ける
];
