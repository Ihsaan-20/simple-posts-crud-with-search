<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/{search?}', [PostController::class, 'index']);
Route::get('/search', [PostController::class, 'search']);

Route::get('/create', [PostController::class, 'create']);
Route::post('/store', [PostController::class, 'store']);
Route::get('/show/{post}', [PostController::class, 'show']);
Route::get('/edit/{post}', [PostController::class, 'edit']);
Route::put('/update/{post}', [PostController::class, 'update']);

Route::delete('/delete/{post}', [PostController::class, 'destroy']);

Route::delete('/post/multi/image/{id}', [PostController::class, 'destroyPostMultiImage'])->name('post.multi.image');
Route::delete('/post/thumbnail/image/{id}', [PostController::class, 'destroyPostThumbnailImage'])->name('post.thumb.image');




