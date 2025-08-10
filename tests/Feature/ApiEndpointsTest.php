<?php

use App\Models\User;
use App\Models\Registration;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create roles
    Role::findOrCreate('super_admin');
    Role::findOrCreate('web_admin');
    Role::findOrCreate('admin_editor');

    // Create a user with an allowed role
    $this->user = User::factory()->create([
        'password' => Hash::make('secret123'),
    ]);
    $this->user->assignRole('super_admin');

    // Create a registration
    $this->registration = Registration::factory()->create([
        'unique_code' => 'ABC123',
        'is_approved' => true,
        'attended_at' => null,
    ]);
});

test('login succeeds for user with allowed role', function () {
    $response = $this->postJson('/api/login', [
        'email'    => $this->user->email,
        'password' => 'secret123',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Login successful.',
        ])
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'user',
                'token',
            ],
        ]);
});

test('login fails for user without allowed role', function () {
    $user = User::factory()->create([
        'password' => Hash::make('secret123'),
    ]);
    // No role assigned

    $response = $this->postJson('/api/login', [
        'email'    => $user->email,
        'password' => 'secret123',
    ]);

    $response->assertStatus(403)
        ->assertJson([
            'success' => false,
            'message' => 'Unauthorized — user does not have permission to login.',
        ]);
});

test('logout works for authenticated user', function () {
    Sanctum::actingAs($this->user);

    $response = $this->postJson('/api/logout');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Logout successful.',
        ]);
});

test('mark attendance works for approved and not attended registration', function () {
    $response = $this->postJson('/api/mark', [
        'unique_code' => 'ABC123',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
        ])
        ->assertJsonStructure([
            'success',
            'message',
            'data',
        ]);

    $this->assertNotNull($this->registration->fresh()->attended_at);
});

test('mark attendance fails if already attended', function () {
    $this->registration->update(['attended_at' => now()]);

    $response = $this->postJson('/api/mark', [
        'unique_code' => 'ABC123',
    ]);

    $response->assertStatus(409)
        ->assertJson([
            'success' => false,
        ]);
});

test('mark attendance fails if registration is not approved', function () {
    $this->registration->update(['is_approved' => false]);

    $response = $this->postJson('/api/mark', [
        'unique_code' => 'ABC123',
    ]);

    $response->assertStatus(403)
        ->assertJson([
            'success' => false,
        ]);
});

test('mark attendance returns registration without marking when override is true', function () {
    $response = $this->postJson('/api/mark', [
        'unique_code' => 'ABC123',
        'override'    => true,
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Override active — returning registration data without marking attendance.',
        ]);

    $this->assertNull($this->registration->fresh()->attended_at);
});
