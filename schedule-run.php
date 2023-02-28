<?php
// OVHのCronに設定されたファイルです。

// php artisan :info が実行されます
$_SERVER['argv'] = [
    'artisan',
    'radodataload:info',
];

// On lance artisan
require __DIR__.'/artisan';