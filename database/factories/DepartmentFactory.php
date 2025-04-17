<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departments = [
            ['name' => 'Computer Science', 'code' => 'CS'],
            ['name' => 'Software Engineering', 'code' => 'SE'],
            ['name' => 'Information Technology', 'code' => 'IT'],
            ['name' => 'Data Science', 'code' => 'DS'],
            ['name' => 'Cybersecurity', 'code' => 'CYB'],
            ['name' => 'Artificial Intelligence', 'code' => 'AI'],
            ['name' => 'Computer Engineering', 'code' => 'CE'],
            ['name' => 'Information Systems', 'code' => 'IS'],
            ['name' => 'Network Engineering', 'code' => 'NE'],
            ['name' => 'Robotics', 'code' => 'ROB'],
        ];

        // Randomly select a department from the list to seed data
        $department = $this->faker->unique()->randomElement($departments);

        return [
            'name' => $department['name'],
            'code' => $department['code'],
            'description' => $this->faker->sentence(10),
        ];
    }
}
