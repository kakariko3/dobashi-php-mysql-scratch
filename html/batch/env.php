<?php

declare(strict_types=1);

// 文字列の中で定数を展開する
$_ = function(string $s): string {return $s;};

// データベース接続情報
define('DB_HOSTNAME', 'db');
define('DB_NAME', 'udemy_db');
define('DB_DSN', "mysql:host={$_(DB_HOSTNAME)};dbname={$_(DB_NAME)};charset=utf8mb4");
define('DB_USERNAME', 'udemy_user');
define('DB_PASSWORD', 'udemy_pass');
