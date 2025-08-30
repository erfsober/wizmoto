<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory {
    protected $model = BlogPost::class;

    public function definition (): array {
        $title = $this->faker->sentence(6);

        return [
            'admin_id' => 1, // or fake admin id
            'title' => $title,
            'summary' => $this->faker->paragraph(2),
            'body' => $this->faker->paragraphs(5, true),
            'views' => $this->faker->numberBetween(0, 5000),
            'published' => $this->faker->boolean(70),
            'slug' => Str::slug($title . '-' . Str::random(5)),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (BlogPost $post) {
            $post->addMedia(public_path('wizmoto/images/resource/inner-blog3-1.jpg'))
                 ->preservingOriginal()
                 ->toMediaCollection('images');
        });
    }
}
