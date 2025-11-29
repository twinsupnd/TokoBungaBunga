<?php

use App\Models\User;

it('denies guests from visiting /dashboard/admin', function () {
    $this->get('/dashboard/admin')->assertRedirect('/login');
});

it('returns 403 for authenticated non-admin/manager users', function () {
    $user = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);
    $this->actingAs($user)->get('/dashboard/admin')->assertStatus(403);
});

it('allows admins to view calendar', function () {
    $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
    $this->actingAs($admin)->get('/dashboard/admin')->assertStatus(200);
});

it('allows managers to view calendar', function () {
    $manager = User::factory()->create(['role' => 'manager', 'email_verified_at' => now()]);
    $this->actingAs($manager)->get('/dashboard/admin')->assertStatus(200);
});
