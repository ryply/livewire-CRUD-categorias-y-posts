<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'date' => $this->faker->date('Y-m-d'),
            'text' => $this->faker->text(500),
            'description' => $this->faker->text(150),
            'posted' => $this->faker->randomElement(['not', 'yes']),
            'type' => $this->faker->randomElement(['adverd', 'post', 'course', 'movie']),
            'category_id' => Category::all()->random()->id
        ];
    }
}
