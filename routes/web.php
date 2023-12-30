<?php



use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Controllers\post\PostController;



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

Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
Route::get('/post/show/{id}', [PostController::class, 'show'])->name('post.show');
Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
Route::put('/post/update', [PostController::class, 'update'])->name('post.update');

Route::delete('/post/delete/{id}', [PostController::class, 'destroy'])->name('post.destroy');

Route::delete('/post/multi/image/{id}', [PostController::class, 'destroyPostMultiImage'])->name('post.multi.image');
Route::delete('/post/thumbnail/image/{id}', [PostController::class, 'destroyPostThumbnailImage'])->name('post.thumb.image');

// Route::get('/post/slug', [PostController::class, 'getSlug'])->name('slug');

// slug generator function route;
Route::get('/post/slug', function(Request $request){

    $slug = '';
    if( !empty($request->title)){
        $slug = Str::slug($request->title);
    }
    return response()->json([
        'status' => true,
        'slug' => $slug
    ]);
})->name('slug');//route end;





