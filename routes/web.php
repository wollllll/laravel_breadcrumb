<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('categories.index'));
});

Route::get('/categories', 'CategoryController@index')->name('categories.index');
