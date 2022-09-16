<?php

declare(strict_types=1);

// 入力値を受け取る
$value = $argv[1];

if ($value % 3 === 0 && $value % 5 === 0) {
    // 入力値が3と5で割り切れる
    echo "FizzBuzz\n";
} else if ($value % 3 === 0) {
    // 入力値が3で割り切れる
    echo "Fizz\n";
} else if ($value % 5 === 0) {
    // 入力値が5で割り切れる
    echo "Buzz\n";
} else {
    // 入力値を出力
    echo "{$value}\n";
}
