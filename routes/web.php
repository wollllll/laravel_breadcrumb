<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('categories.index'));
});

Route::get('/categories', 'CategoryController@index')->name('categories.index');
Route::get('/categories/{category}', 'CategoryController@show')->name('categories.show');
Route::get('/categories/{category}/posts/{post}', 'PostController@show')->name('posts.show');

Route::get('/dummies/{dummy}', 'DummyController@show')->name('dummies.show');
