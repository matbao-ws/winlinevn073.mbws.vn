<?php

use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\BrandController;
use App\Http\Controllers\Client\CalculatorController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\NewsController;
use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\PostCategoryController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\ProjectController;
use App\Http\Controllers\Client\SolutionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gioi-thieu', [AboutController::class, 'index'])->name('about');
Route::get('/san-pham', [ProductController::class, 'index'])->name('products');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('products.detail');
Route::get('/cong-cu-tinh-quat', [CalculatorController::class, 'index'])->name('calculator');
Route::get('/thuong-hieu', [BrandController::class, 'index'])->name('brands');
Route::get('/giai-phap', [SolutionController::class, 'index'])->name('solutions');
Route::get('/du-an', [ProjectController::class, 'index'])->name('projects');
Route::get('/tin-tuc', [NewsController::class, 'index'])->name('news');
Route::get('/tin-tuc/{slug}', [NewsController::class, 'show'])->name('news.detail');
Route::get('/lien-he', [ContactController::class, 'index'])->name('contact');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.submit');

Route::get('pages/{slug}', [PageController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('pages.show');

Route::get('danh-muc/{slug}', [CategoryController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('categories.show');

Route::get('chuyen-muc/{slug}', [PostCategoryController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-_]+')
    ->name('post-categories.show');

if (app()->environment(['local', 'testing'])) {
    Route::view('sandbox/inline-editor', 'client.dev.toolbar-sandbox')
        ->name('dev.toolbar-sandbox');
    Route::view('sandbox/inline-editor-stress', 'client.dev.toolbar-stress')
        ->name('dev.toolbar-stress');
}
