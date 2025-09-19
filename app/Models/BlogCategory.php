<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BlogPost;

class BlogCategory extends Model
{
    use HasFactory;
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }
}
