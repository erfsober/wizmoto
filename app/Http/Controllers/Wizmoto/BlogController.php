<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller {
    public function index ( Request $request ) {
        $blogPosts = BlogPost::query()
                             ->where('published' , true)
                             ->latest()
                             ->paginate(9);

        return view('wizmoto.blog.index' , compact('blogPosts'));
    }

    public function show ( $slug ) {

        $blogPost = BlogPost::query()
                            ->with([ 'reviews' ])
                            ->where('slug' , $slug)
                            ->where('published' , true)
                            ->firstOrFail();
        $blogPost->increment('views');
        $latestBlogs = BlogPost::query()
                               ->latest()
                               ->take(3)
                               ->get();
        $previous = BlogPost::where('id' , '<' , $blogPost->id)
                            ->latest('id')
                            ->first();
        $next = BlogPost::where('id' , '>' , $blogPost->id)
                        ->first();

        return view('wizmoto.blog.show' , compact('blogPost' , 'latestBlogs' , 'next' , 'previous'));
    }
}
