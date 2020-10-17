<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Category $category, Post $post)
    {
        return view('posts.show', compact('category', 'post'));
    }
}
