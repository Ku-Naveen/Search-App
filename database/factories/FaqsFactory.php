<?php

namespace Database\Factories;

use App\Models\Faqs;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faqs>
 */
class FaqsFactory extends Factory
{
    protected $model = Faqs::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence . '?',
            'answer' => $this->faker->paragraph,
        ];
    }
}
