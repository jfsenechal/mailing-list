<?php

declare(strict_types=1);

use App\Enums\Role;
use App\Models\User;

use function Pest\Laravel\assertDatabaseHas;

it('creates a user from options', function (): void {
    $this->artisan('app:create-user', [
        '--first-name' => 'Jane',
        '--last-name' => 'Doe',
        '--username' => 'janedoe',
        '--email' => 'jane@example.com',
        '--password' => 'SuperSecret123',
        '--role' => 'admin',
    ])->assertSuccessful();

    assertDatabaseHas(User::class, [
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'username' => 'janedoe',
        'email' => 'jane@example.com',
        'role' => Role::Admin->value,
    ]);
});

it('rejects an invalid role', function (): void {
    $this->artisan('app:create-user', [
        '--first-name' => '',
        '--last-name' => '',
        '--username' => '',
        '--email' => 'jane@example.com',
        '--password' => 'SuperSecret123',
        '--role' => 'superhero',
    ])->assertFailed();

    expect(User::where('email', 'jane@example.com')->exists())->toBeFalse();
});

it('rejects a password shorter than 12 characters', function (): void {
    $this->artisan('app:create-user', [
        '--first-name' => '',
        '--last-name' => '',
        '--username' => '',
        '--email' => 'jane@example.com',
        '--password' => 'Short1',
        '--role' => 'user',
    ])->assertFailed();

    expect(User::where('email', 'jane@example.com')->exists())->toBeFalse();
});

it('rejects a duplicate email', function (): void {
    User::factory()->create(['email' => 'taken@example.com']);

    $this->artisan('app:create-user', [
        '--first-name' => '',
        '--last-name' => '',
        '--username' => '',
        '--email' => 'taken@example.com',
        '--password' => 'SuperSecret123',
        '--role' => 'user',
    ])->assertFailed();
});
