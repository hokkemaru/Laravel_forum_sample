<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\CodeController;

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

Route::get('/', [ForumController::class, 'index'])
    ->name('home');
Route::get('/post', [ForumController::class, 'post'])
    ->name('post');
Route::post('/post', [ForumController::class, 'create'])
    ->name('create');
Route::get('/forum_detail', [ForumController::class, 'detail'])
    ->name('detail');
Route::post('/forum_detail_good', [ForumController::class, 'good'])
    ->name('detail_good');
Route::get('/edit', [ForumController::class, 'edit'])
    ->name('edit');
Route::post('/edit', [ForumController::class, 'update'])
    ->name('update');
Route::post('/destroy', [ForumController::class, 'destroy'])
    ->name('destroy');
Route::post('/comment', [ForumController::class, 'comment'])
    ->name('comment');
Route::post('/child_comment', [ForumController::class, 'childComment'])
    ->name('child_comment');


Route::get('/login', [LoginController::class, 'index'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])
    ->middleware('guest')
    ->name('authenticate');
Route::get('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/register', [RegisterController::class, 'index'])
    ->middleware('guest')
    ->name('register');
Route::post('/register', [RegisterController::class, 'signup'])
    ->middleware('guest')
    ->name('signup');

Route::get('/code_maintenance', [CodeController::class, 'index'])
    ->name('code_maintenance');
Route::post('/code_maintenance', [CodeController::class, 'create'])
    ->name('code_create');

Route::post('/code_update', [CodeController::class, 'update'])
    ->name('code_update');
Route::post('/code_destroy', [CodeController::class, 'destroy'])
    ->name('code_destroy');

