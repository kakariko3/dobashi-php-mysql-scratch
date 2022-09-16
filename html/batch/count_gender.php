<?php

declare(strict_types=1);

// 社員情報CSVをオープン
$fp = fopen(__DIR__ . '/input.csv', 'r');

// ファイルを1行ずつ読み込み、終端まで繰り返し
$lineCount = 0;
$manCount = 0;
$womanCount = 0;
while ($data = fgetcsv($fp)) {
    $lineCount++;
    if ($lineCount === 1) {
        // 1行目の場合は次の行へスキップ
        continue;
    }
    var_dump($data);

    if ($data[4] === '男性') {
        $manCount++;
    } else {
        $womanCount++;
    }
}

// 社員情報CSVをクローズ
fclose($fp);

// Debug
echo "{$manCount}, {$womanCount}\n";

// 出力ファイルをオープン
$fpOut = fopen(__DIR__ . '/output.csv', 'w');

// ヘッダー行（1行目）の書き込み
$header = ['男性', '女性'];
fputcsv($fpOut, $header);

// 人数データの書き込み
$outputData = [$manCount, $womanCount];
fputcsv($fpOut, $outputData);

// 出力ファイルをクローズ
fclose($fpOut);
