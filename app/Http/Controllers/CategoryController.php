<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category): View
    {
        $category->load('posts');

        return view('categories.show', compact('category'));
    }
}
