<?php

use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\BrandController;
use App\Http\Controllers\Client\CalculatorController;
use App\Http\Controllers\Client\CatalogResolverController;
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
Route::get('/danh-muc-san-pham', [ProductController::class, 'index'])->name('products.catalog.alias');
Route::get('/loai-quat/{slug}', fn (\Illuminate\Http\Request $request, string $locale, string $slug) => redirect('/' . $locale . '/' . $slug, 301));
Route::get('/he-thong-lam-mat-trang-trai', fn (\Illuminate\Http\Request $request, string $locale) => redirect('/' . $locale . '/tam-lam-mat-cooling-pad', 301));
Route::get('/quat-thong-gio-noi-ong-cabinet-tieu-am', fn (\Illuminate\Http\Request $request, string $locale) => redirect('/' . $locale . '/quat-ly-tam', 301));
Route::get('/quat-hut-cong-nghiep-vuong', fn (\Illuminate\Http\Request $request, string $locale) => redirect('/' . $locale . '/quat-thong-gio-vuong', 301));
Route::get('/quat-thong-gio-cong-nghiep-tron', fn (\Illuminate\Http\Request $request, string $locale) => redirect('/' . $locale . '/quat-huong-truc', 301));
Route::get('/quat-ly-tam-hut-bep', fn (\Illuminate\Http\Request $request, string $locale) => redirect('/' . $locale . '/quat-ly-tam', 301));
Route::get('/quat-hut-di-dong', fn (\Illuminate\Http\Request $request, string $locale) => redirect('/' . $locale . '/quat-hut-xach-tay', 301));
Route::get('/san-pham-count', [ProductController::class, 'count'])->name('products.count');
Route::get('/san-pham-search-live', [ProductController::class, 'searchLive'])->name('products.search.live');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('products.detail');
Route::get('/cong-cu-tinh-quat', [CalculatorController::class, 'index'])->name('calculator');
Route::redirect('/cong-cu-tinh-toan-chon-quat', '/vi/cong-cu-tinh-quat');
Route::get('/cong-cu-tinh-quat/products', [CalculatorController::class, 'apiProducts'])->name('calculator.products');
Route::post('/cong-cu-tinh-quat/balance', [CalculatorController::class, 'balance'])->name('calculator.balance');
Route::post('/cong-cu-tinh-quat/save', [CalculatorController::class, 'save'])->name('calculator.save');
Route::get('/du-tinh/{publicId}', [CalculatorController::class, 'showEstimation'])->name('calculator.estimation');
Route::get('/du-tinh/{publicId}/pdf', [CalculatorController::class, 'pdf'])->name('calculator.pdf');
Route::post('/du-tinh/{publicId}/submit', [CalculatorController::class, 'submitRfq'])->name('calculator.submit');

Route::get('/thuong-hieu', [BrandController::class, 'index'])->name('brands');
Route::get('/giai-phap', [SolutionController::class, 'index'])->name('solutions');
Route::get('/chon-theo-nhu-cau', [SolutionController::class, 'index'])->name('demands');
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

Route::get('/{slug}', [CatalogResolverController::class, 'resolve'])
    ->where('slug', '^(?!admin|api|login|customer|payment|up)[a-zA-Z0-9\-_]+$')
    ->name('catalog.resolve');

