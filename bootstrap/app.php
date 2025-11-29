<?php

// Hide deprecation notices (PHP 8.5+). Some upstream libraries still use
// deprecated constants (e.g. PDO::MYSQL_ATTR_SSL_CA). Showing deprecation
// messages during artisan commands is noisy — we turn them off here so the
// application output stays clear while leaving other error types visible.
if (defined('E_DEPRECATED') && defined('E_USER_DEPRECATED')) {
    error_reporting(error_reporting() & ~E_DEPRECATED & ~E_USER_DEPRECATED);
}

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
