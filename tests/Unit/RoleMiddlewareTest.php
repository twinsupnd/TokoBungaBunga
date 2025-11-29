<?php

use App\Http\Middleware\RoleMiddleware;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

// Bind Laravel test case so the application container (auth, helpers) is available.
uses(Tests\TestCase::class);

it('denies guest requests with 403', function () {
    $middleware = new RoleMiddleware();
    $request = Request::create('/dashboard/manage-admins', 'GET');

    expect(fn () => $middleware->handle($request, fn () => 'next', 'manager'))
        ->toThrow(HttpException::class);
});

it('denies authenticated non-manager users', function () {
    $middleware = new RoleMiddleware();
    $request = Request::create('/dashboard/manage-admins', 'GET');

    // create a user object without persisting
    $user = new User(['role' => 'admin']);
    auth()->setUser($user);

    expect(fn () => $middleware->handle($request, fn () => 'next', 'manager'))
        ->toThrow(HttpException::class);
});

it('allows authenticated manager users', function () {
    $middleware = new RoleMiddleware();
    $request = Request::create('/dashboard/manage-admins', 'GET');

    $manager = new User(['role' => 'manager']);
    auth()->setUser($manager);

    $result = $middleware->handle($request, fn () => 'next', 'manager');

    expect($result)->toBe('next');
});
