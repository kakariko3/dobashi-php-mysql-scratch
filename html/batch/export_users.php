<?php

declare(strict_types=1);

require_once './env.php';

// データベースに接続
try {
    $dbh = new PDO(
        DB_DSN,
        DB_USERNAME,
        DB_PASSWORD,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    $error = $e->getMessage();
}

// 社員情報取得SQLの実行
try {
    $sql = 'SELECT * FROM users ORDER BY id';
    // プリペアドステートメント
    $stmt = $dbh->prepare($sql);
    // SQLの実行
    $stmt->execute();
} catch (PDOException $e) {
    $error = $e->getMessage();
}

// SQL結果を1行ずつ読み込み、終端まで繰り返し
$outputData = [];
$dataCount = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // 出力データの作成
    $outputData[$dataCount]['id'] = $row['id'];
    $outputData[$dataCount]['name'] = $row['name'];
    $outputData[$dataCount]['name_kana'] = $row['name_kana'];
    $outputData[$dataCount]['birthday'] = $row['birthday'];
    $outputData[$dataCount]['gender'] = $row['gender'];
    $outputData[$dataCount]['organization'] = $row['organization'];
    $outputData[$dataCount]['post'] = $row['post'];
    $outputData[$dataCount]['start_date'] = $row['start_date'];
    $outputData[$dataCount]['tel'] = $row['tel'];
    $outputData[$dataCount]['mail_address'] = $row['mail_address'];
    $outputData[$dataCount]['created'] = $row['created'];
    $outputData[$dataCount]['updated'] = $row['updated'];
    $dataCount++;
}

// Debug
var_export($outputData);

// 出力ファイルをオープン
$fpOut = fopen(__DIR__ . '/export_user.csv', 'w');

// ヘッダー行の書き込み
$header = [
    '社員番号',
    '社員名',
    '社員名カナ',
    '生年月日',
    '性別',
    '所属部署',
    '役職',
    '入社年月日',
    '電話番号',
    'メールアドレス',
    '作成日時',
    '更新日時',
];
fputcsv($fpOut, $header);

// 出力データの書き込み（繰り返し）
foreach ($outputData as $data) {
    fputcsv($fpOut, $data);
}

// 出力ファイルをクローズ
fclose($fpOut);
