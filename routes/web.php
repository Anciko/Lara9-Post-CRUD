<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::get('/', [PostController::class, 'index'])->name('post.index');
Route::post('post', [PostController::class, 'create'])->name('post.create');
Route::get('post/details/{id}', [PostController::class, 'show'])->name('post.show');
Route::get('post/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
Route::put('/post/{id}', [PostController::class, 'update'])->name('post.update');
Route::delete('post/{id}', [PostController::class, 'destroy'])->name('post.destroy');
