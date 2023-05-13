<?php
// OVHのCronに設定されたファイルです。

// php artisan :info が実行されます
$_SERVER['argv'] = [
    'artisan',
    'dinnerstock:manager',
];

// On lance artisan
require __DIR__.'/artisan';