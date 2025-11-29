<?php

use App\Models\User;

it('redirects unauthenticated users to login when accessing manage admins', function () {
    $this->get('/dashboard/manage-admins')
        ->assertRedirect('/login');
});

it('returns 403 for authenticated non-manager users', function () {
    $user = User::factory()->create(["role" => "admin", 'email_verified_at' => now()]);

    $this->actingAs($user)
        ->get('/dashboard/manage-admins')
        ->assertStatus(403);
});

it('allows manager users to access manage admins page', function () {
    $manager = User::factory()->create(["role" => "manager", 'email_verified_at' => now()]);

    $this->actingAs($manager)
        ->get('/dashboard/manage-admins')
        ->assertRedirect('/dashboard');
});
