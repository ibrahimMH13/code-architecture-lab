<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $priority = ["high","medium","low"];
        return [
            "priority" => $priority[array_rand(["high","medium","low"])],
            "title" => $this->faker->title,
            "body" => $this->faker->paragraph
        ];
    }
}
