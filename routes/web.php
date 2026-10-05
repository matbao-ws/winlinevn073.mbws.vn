<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/vi');
Route::get('/login', fn () => redirect('/'.app(\App\Services\LanguageRegistry::class)->defaultLocale().'/admin/login'))->name('login');

Route::get('/api/docs', [\App\Http\Controllers\Api\PublicController::class, 'docs'])->name('api.docs');

Route::get('/customer/reset-password/{token}', [\App\Http\Controllers\Auth\CustomerResetPasswordController::class, 'create'])->name('customer.password.reset');
Route::post('/customer/reset-password', [\App\Http\Controllers\Auth\CustomerResetPasswordController::class, 'store'])
    ->middleware('throttle:public-auth')
    ->name('customer.password.update');

if (config('app.payment_mock_enabled') && app()->environment(['local', 'testing'])) {
    Route::get('/payment/vnpay/mock', [\App\Http\Controllers\Api\PublicController::class, 'vnpayMockPayment'])->name('vnpay.mock');
    Route::post('/payment/vnpay/mock/submit', [\App\Http\Controllers\Api\PublicController::class, 'vnpayMockSubmit'])
        ->middleware('throttle:10,1')
        ->name('vnpay.mock.submit');
}

Route::get('/docs/user-manual.html', function() {
    return response()->file(base_path('docs/user-manual.html'), ['Content-Type' => 'text/html; charset=UTF-8']);
});
Route::get('/docs/user-manual-print.html', function() {
    return response()->file(base_path('docs/user-manual-print.html'), ['Content-Type' => 'text/html; charset=UTF-8']);
});
Route::get('/docs/Huong_Dan_Su_Dung_Admin_Winline.pdf', function() {
    return response()->file(base_path('docs/Huong_Dan_Su_Dung_Admin_Winline.pdf'), ['Content-Type' => 'application/pdf']);
});
Route::get('/huong-dan-su-dung', function() {
    return response()->file(base_path('docs/user-manual.html'), ['Content-Type' => 'text/html; charset=UTF-8']);
})->name('user-manual');

Route::get('/he-thong-lam-mat-trang-trai', fn () => redirect('/vi/tam-lam-mat-cooling-pad', 301));
Route::get('/quat-thong-gio-noi-ong-cabinet-tieu-am', fn () => redirect('/vi/quat-ly-tam', 301));
Route::get('/quat-hut-cong-nghiep-vuong', fn () => redirect('/vi/quat-thong-gio-vuong', 301));
Route::get('/quat-thong-gio-cong-nghiep-tron', fn () => redirect('/vi/quat-huong-truc', 301));
Route::get('/quat-ly-tam-hut-bep', fn () => redirect('/vi/quat-ly-tam', 301));
Route::get('/quat-hut-di-dong', fn () => redirect('/vi/quat-hut-xach-tay', 301));
Route::get('/du-an', fn () => redirect('/vi/gioi-thieu', 301));

Route::get('/loai-quat/{slug}', function (\Illuminate\Http\Request $request, string $slug) {
    $queryString = $request->getQueryString();
    $target = '/vi/' . $slug . ($queryString ? '?' . $queryString : '');
    return redirect($target, 301);
});

Route::get('/{slug}', function (\Illuminate\Http\Request $request, string $slug) {
    $queryString = $request->getQueryString();
    $target = '/vi/' . $slug . ($queryString ? '?' . $queryString : '');
    return redirect($target, 301);
})->where('slug', '^(?!vi$|en$|admin|api|login|customer|payment|up|docs|huong-dan-su-dung)[a-zA-Z0-9\-_]+$');


