<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(['CRM System', 'ERP System', 'Online Ordering and Delivery System', 'Restuarant Management System', 'Personal Portfolio', 'LMS System']),
            'detail' => fake()->text(),
            'client_name' => fake()->name(),
            'total_cost' => fake()->randomDigit(),
            'deadline' => fake()->date()
        ];
    }
}
