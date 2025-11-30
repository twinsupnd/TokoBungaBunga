<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

try {
    // Update all admins and managers to be verified
    $updated = User::whereIn('role', ['admin', 'manager'])
        ->whereNull('email_verified_at')
        ->update(['email_verified_at' => now()]);
    
    echo "Updated $updated admin/manager users to verified status.\n";
    
    // Show updated users
    $users = User::whereIn('role', ['admin', 'manager'])->get();
    echo "\nAdmin/Manager users now:\n";
    foreach ($users as $user) {
        echo "  - {$user->name} ({$user->email}) - Verified: " . ($user->email_verified_at ? 'YES' : 'NO') . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
