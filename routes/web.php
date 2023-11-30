<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/show', function () {
    return view('show');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// taskのRoute
Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');

Route::get('/tasks/create', [App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');

Route::post('/tasks', [App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');

Route::get('/tasks/{id}', [App\Http\Controllers\TaskController::class, 'show'])->name('tasks.show');

Route::get('/tasks/{id}/edit', [App\Http\Controllers\TaskController::class, 'edit'])->name('tasks.edit');

Route::put('/tasks/{id}', [App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');

Route::delete('/tasks/{id}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('tasks.destroy');

Route::post('/tasks/{task_id}/upload-image', [App\Http\Controllers\TaskController::class, 'uploadImage'])->name('tasks.upload-image');

//likeのRoute
Route::get('/tasks/{task_id}/likes', [App\Http\Controllers\LikeController::class, 'store'])->name('likes.store');

Route::delete('/likes/{like_id}', [App\Http\Controllers\LikeController::class, 'destroy'])->name('likes.destroy');

//userのRoute
Route::get('/user/show{id}', [App\Http\Controllers\UserController::class, 'show'])->name('show');

