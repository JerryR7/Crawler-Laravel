<?php

namespace Database\Factories;

use App\Models\CrawledResult;
use Illuminate\Database\Eloquent\Factories\Factory;

class CrawledResultFactory extends Factory
{
    protected $model = CrawledResult::class;

    public function definition(): array
    {
        return [
            'url' => $this->faker->url,
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'description' => $this->faker->sentence,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
