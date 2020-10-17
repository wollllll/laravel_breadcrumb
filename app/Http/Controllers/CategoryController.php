<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $categories = Category::get();

        return view('categories.index', compact('categories'));
    }

    /**
     * @param Category $category
     * @return View
     */
    public function show(Category $category): View
    {
        $category->load('posts');

        return view('categories.show', compact('category'));
    }
}
