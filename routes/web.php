<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth:sanctum', 'verified'], 'prefix' => 'dashboard'], function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUDs
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', App\Http\Livewire\Dashboard\Category\Index::class)->name('d-category-index');         // listar
        Route::get('/create', App\Http\Livewire\Dashboard\Category\Save::class)->name('d-category-create');   // crear
        Route::get('/edit/{id}', App\Http\Livewire\Dashboard\Category\Save::class)->name('d-category-edit');  // editar
    });

    Route::group(['prefix' => 'post'], function () {
        Route::get('/', App\Http\Livewire\Dashboard\Post\Index::class)->name('d-post-index');         // listar
        Route::get('/create', App\Http\Livewire\Dashboard\Post\Save::class)->name('d-post-create');   // crear
        Route::get('/edit/{id}', App\Http\Livewire\Dashboard\Post\Save::class)->name('d-post-edit');  // editar
    });

});


