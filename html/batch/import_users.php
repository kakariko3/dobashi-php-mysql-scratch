<?php

declare(strict_types=1);

require_once './library/log.php';

$logFile = __DIR__ . '/log/import_users.log';
writeLog($logFile, '社員情報登録バッチ 開始');
$dataCount = 0;

require_once './env.php';

try {
    // データベースに接続
    $dbh = new PDO(
        DB_DSN,
        DB_USERNAME,
        DB_PASSWORD,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    // 社員情報CSVオープン
    $fp = fopen(__DIR__ . '/import_users.csv', 'r');

    // トランザクション
    $dbh->beginTransaction();

    // ファイルを1行ずつ読み込み、終端まで繰り返し
    while ($data = fgetcsv($fp)) {
        // 社員番号をキーに社員情報を取得
        $sql = 'SELECT COUNT(*) AS count FROM users WHERE id = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
            ':id' => $data[0],
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debug
        // var_export($data[0]);
        // var_export($result);

        // SQL実行結果の件数によって条件分岐
        if ($result['count'] === 0) {
            // 社員情報登録SQL
            $sql =
                'INSERT INTO users (
                    id,
                    name,
                    name_kana,
                    birthday,
                    gender,
                    organization,
                    post,
                    start_date,
                    tel,
                    mail_address,
                    created,
                    updated
                ) VALUES (
                    :id,
                    :name,
                    :name_kana,
                    :birthday,
                    :gender,
                    :organization,
                    :post,
                    :start_date,
                    :tel,
                    :mail_address,
                    NOW(),
                    NOW()
                )';
        } else {
            // 社員情報更新SQL
            $sql =
                'UPDATE users SET
                    name = :name,
                    name_kana = :name_kana,
                    birthday = :birthday,
                    gender = :gender,
                    organization = :organization,
                    post = :post,
                    start_date = :start_date,
                    tel = :tel,
                    mail_address = :mail_address,
                    updated = NOW()
                WHERE id = :id
                ';
        }
        // SQLの実行
        $stmt = $dbh->prepare($sql);
        $stmt->execute([
            ':id' => $data[0],
            ':name' => $data[1],
            ':name_kana' => $data[2],
            ':birthday' => $data[3],
            ':gender' => $data[4],
            ':organization' => $data[5],
            ':post' => $data[6],
            ':start_date' => $data[7],
            ':tel' => $data[8],
            ':mail_address' => $data[9],
        ]);
        $dataCount++;
    }

    // コミット
    $dbh->commit();

    // 社員情報CSVのクローズ
    fclose($fp);

    writeLog($logFile, "社員情報登録バッチ 終了[処理件数: {$dataCount}件]");
} catch (Exception $e) {
    // ロールバック
    $dbh->rollBack();

    $dataCount = 0;
    writeLog($logFile, "エラーが発生しました {$e->getMessage()}");
}
