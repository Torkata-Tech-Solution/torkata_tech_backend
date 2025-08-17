<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio>
 */
class PortfolioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);
        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'description' => fake()->paragraph(),
            'content' => fake()->paragraphs(5, true),
            'client_name' => fake()->company(),
            'project_url' => fake()->url(),
            'github_url' => 'https://github.com/' . fake()->userName() . '/' . \Illuminate\Support\Str::slug($title),
            'technologies' => fake()->randomElements(['PHP', 'Laravel', 'Vue.js', 'React', 'JavaScript', 'MySQL', 'PostgreSQL', 'Redis', 'Docker'], rand(3, 6)),
            'project_date' => fake()->dateTimeBetween('-2 years', 'now'),
            'status' => fake()->randomElement(['draft', 'published']),
            'order' => fake()->numberBetween(1, 100),
            'user_id' => 1,
            'meta_title' => $title,
            'meta_description' => fake()->sentence(),
            'meta_keywords' => implode(', ', fake()->words(5))
        ];
    }
}
