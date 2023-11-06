<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommmentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix' => 'post', 'as' => 'post.'], function(){
        Route::get('/', [PostController::class, 'list'])->name('list');
        Route::get('/own', [PostController::class, 'own'])->name('own');
        Route::get('/show/{id}', [PostController::class, 'show'])->name('show');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PostController::class, 'edit'])->name('edit');
        Route::post('/update', [PostController::class, 'update'])->name('update');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::delete('/delete/{id}', [PostController::class, 'delete'])->name('delete');
        Route::get('/restore/{id}', [PostController::class, 'restore'])->name('restore');
        
        Route::group(['prefix' => 'comment', 'as' => 'comment.'], function(){
            Route::post('/store', [CommmentController::class, 'store'])->name('store');
            Route::post('/update', [CommmentController::class, 'update'])->name('update');
        });
    });
});

require __DIR__.'/auth.php';
