<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder {
    public function run (): void {
        BlogPost::query()
                ->truncate();
        $categories = BlogCategory::all();
        BlogPost::factory()
                ->count(50)
                ->create()
                ->each(function ( $post ) use ( $categories ) {
                    if ( $categories->count() ) {
                        $post->blog_category_id = $categories->random()->id;
                        $post->save();
                    }
                });
    }
}
