<?php

declare(strict_types=1);

/**
 * ログを出力する
 * 
 * @param string $fileName 出力するログファイル名
 * @param string $message ログファイルに書き込むメッセージ
 * @return void
 */
function writeLog(string $fileName, string $message): void {
    $now = date('Y/m/d H:i:s');
    $log = "{$now} {$message}\n";

    // ログファイルを作成
    $fp = fopen($fileName, 'a');
    fwrite($fp, $log);
    fclose($fp);
}
