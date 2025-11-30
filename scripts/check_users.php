<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

try {
    // Check users count
    $userCount = User::count();
    echo "Total users in database: $userCount\n\n";
    
    // List all users
    $users = User::select('id', 'name', 'email', 'role', 'email_verified_at')->get();
    echo "Users:\n";
    foreach ($users as $user) {
        echo "  - ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}, Verified: " . ($user->email_verified_at ? 'YES' : 'NO') . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
