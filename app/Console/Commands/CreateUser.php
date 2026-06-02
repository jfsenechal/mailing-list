<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

use function Laravel\Prompts\password as promptPassword;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

#[Signature('app:create-user
    {--first-name= : The first name of the user}
    {--last-name= : The last name of the user}
    {--username= : The username of the user}
    {--email= : The email address of the user}
    {--password= : The password of the user}
    {--role= : The role of the user (admin, user)}')]
#[Description('Create a new user')]
final class CreateUser extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $firstName = $this->option('first-name') ?? text(label: 'First name');
        $lastName = $this->option('last-name') ?? text(label: 'Last name');
        $username = $this->option('username') ?? text(label: 'Username');

        $email = $this->option('email') ?? text(
            label: 'Email',
            required: true,
        );

        $password = $this->option('password') ?? promptPassword(
            label: 'Password',
            required: true,
        );

        $role = $this->option('role') ?? select(
            label: 'Role',
            options: collect(Role::cases())
                ->mapWithKeys(fn (Role $role): array => [$role->value => $role->getLabel()])
                ->all(),
            default: Role::User->value,
        );

        $validator = Validator::make([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ], [
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::min(12)->mixedCase()->numbers()],
            'role' => ['required', Rule::enum(Role::class)],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->components->error($error);
            }

            return self::FAILURE;
        }

        $user = User::create([
            'first_name' => $firstName ?: null,
            'last_name' => $lastName ?: null,
            'username' => $username ?: null,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
        ]);

        $this->components->info("User [{$user->email}] created successfully.");

        return self::SUCCESS;
    }
}
