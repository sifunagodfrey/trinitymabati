<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * -------------------
 * User Factory (Aligned with su_users)
 * -------------------
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            // -------------------
            // Required Fields
            // -------------------
            'role_id' => UserRole::inRandomOrder()->value('id') ?? 2,

            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),

            'email' => fake()->unique()->safeEmail(),

            'email_verified_at' => now(),

            'password' => static::$password ??= Hash::make('password'),

            'remember_token' => Str::random(10),

            // -------------------
            // Optional Fields
            // -------------------
            'status' => 'active',
            'is_owner' => 0,
            'has_active_subscription' => 0,
        ];
    }

    /**
     * -------------------
     * Unverified State
     * -------------------
     */
    public function unverified(): static
    {
        return $this->state(fn () => [
            'email_verified_at' => null,
        ]);
    }
}