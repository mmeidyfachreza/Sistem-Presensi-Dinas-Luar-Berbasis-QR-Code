<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $username = strtolower($this->faker->unique()->firstName());
        return [
            'name' => $username,
            'no_identity' => $this->faker->numerify('#########'),
            'email' => $username.'@thortech.corp',
            'phone_number' => $this->faker->numerify('#########'),
            'division' => $this->faker->jobTitle()
        ];
    }
}
