<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormService>
 */
class FormServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['diterima', 'proses', 'selesai']),
            'id_customer' => Customer::factory(),
            'id_user' => User::factory(),
        ];
    }

    /**
     * Set status to diterima
     */
    public function diterima(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'diterima',
        ]);
    }

    /**
     * Set status to proses
     */
    public function proses(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'proses',
        ]);
    }

    /**
     * Set status to selesai
     */
    public function selesai(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'selesai',
        ]);
    }
}
