<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest layout component exists and renders', function () {
    $response = $this->get('/login');
    
    $response->assertStatus(200);
    $response->assertSee('<x-guest-layout>', false);
});

test('app layout component exists and renders for authenticated users', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/dashboard');
    
    $response->assertStatus(200);
    $response->assertSee('<x-app-layout>', false);
});

test('login page renders with guest layout', function () {
    $response = $this->get('/login');
    
    $response->assertStatus(200);
    $response->assertViewIs('auth.login');
    $response->assertSee('Email');
    $response->assertSee('Password');
});

test('register page renders with guest layout', function () {
    $response = $this->get('/register');
    
    $response->assertStatus(200);
    $response->assertViewIs('auth.register');
    $response->assertSee('Name');
    $response->assertSee('Email');
    $response->assertSee('Password');
});

test('dashboard renders with app layout for authenticated users', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/dashboard');
    
    $response->assertStatus(200);
    $response->assertViewIs('dashboard');
});

test('navigation component shows correct links for different roles', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $author = User::factory()->create(['role' => 'auteur']);
    $user = User::factory()->create(['role' => 'user']);
    
    $adminResponse = $this->actingAs($admin)->get('/dashboard');
    $authorResponse = $this->actingAs($author)->get('/dashboard');
    $userResponse = $this->actingAs($user)->get('/dashboard');
    
    $adminResponse->assertSee('Admin Dashboard');
    $authorResponse->assertSee('Author Dashboard');
    $userResponse->assertDontSee('Admin Dashboard');
    $userResponse->assertDontSee('Author Dashboard');
});

test('all blade components are properly registered', function () {
    $componentsPath = resource_path('views/components');
    
    expect(file_exists($componentsPath . '/guest-layout.blade.php'))->toBeTrue();
    expect(file_exists($componentsPath . '/app-layout.blade.php'))->toBeTrue();
    expect(file_exists($componentsPath . '/text-input.blade.php'))->toBeTrue();
    expect(file_exists($componentsPath . '/primary-button.blade.php'))->toBeTrue();
    expect(file_exists($componentsPath . '/input-label.blade.php'))->toBeTrue();
});