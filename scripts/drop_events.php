<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;
try {
    DB::statement('DROP TABLE IF EXISTS `events`');
    echo "Dropped table events (if it existed)\n";
} catch (Exception $e) {
    echo "Error dropping events: " . $e->getMessage() . "\n";
}
