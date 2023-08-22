<?php
// OVHのCronに設定されたファイルです。

// php artisan rapelle:do が実行されます
$_SERVER['argv'] = [
    'artisan',
    'rapelle:do',
];

// On lance artisan
require __DIR__.'/artisan';