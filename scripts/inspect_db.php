<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $res = DB::select("SHOW TABLE STATUS LIKE 'users'");
    echo "Table status:\n";
    print_r($res);

    $cols = DB::select("SHOW COLUMNS FROM `users`");
    echo "\nColumns:\n";
    print_r($cols);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
