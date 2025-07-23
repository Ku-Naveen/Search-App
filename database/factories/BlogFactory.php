<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
     protected $model = Blog::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
             'title' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(5, true),
            'tags' => implode(',', $this->faker->words(3)),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
