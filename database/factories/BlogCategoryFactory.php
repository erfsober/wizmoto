<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogCategory>
 */
class BlogCategoryFactory extends Factory {
    protected $model = BlogCategory::class;

    public function definition (): array {
        $title = $this->faker->unique()->words(2, true);

        return [
            'title' => ucfirst($title),
            'published' => $this->faker->boolean(80),
            'slug' => Str::slug($title),
            'sort' => $this->faker->numberBetween(1, 100),
        ];
    }
}
