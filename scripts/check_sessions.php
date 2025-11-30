<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Check if sessions table exists
    $exists = DB::statement("SHOW TABLES LIKE 'sessions'");
    echo "Sessions table exists: " . ($exists ? "YES" : "NO") . "\n";
    
    // Try to clean expired sessions
    DB::table('sessions')->where('last_activity', '<', now()->subMinutes(120)->timestamp)->delete();
    echo "Cleaned expired sessions.\n";
    
    // Count remaining sessions
    $count = DB::table('sessions')->count();
    echo "Remaining sessions: $count\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
