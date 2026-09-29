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
Route::get('/docs/bien-ban-ban-giao.html', function() {
    return response()->file(base_path('docs/bien-ban-ban-giao.html'), ['Content-Type' => 'text/html; charset=UTF-8']);
});
Route::get('/docs/Bien_Ban_Ban_Giao_Va_Nghiem_Thu_Winline.pdf', function() {
    return response()->file(base_path('docs/Bien_Ban_Ban_Giao_Va_Nghiem_Thu_Winline.pdf'), ['Content-Type' => 'application/pdf']);
});
Route::get('/huong-dan-su-dung', function() {
    return response()->file(base_path('docs/user-manual.html'), ['Content-Type' => 'text/html; charset=UTF-8']);
})->name('user-manual');
Route::get('/bien-ban-ban-giao', function() {
    return response()->file(base_path('docs/bien-ban-ban-giao.html'), ['Content-Type' => 'text/html; charset=UTF-8']);
})->name('handover-certificate');

Route::get('/{slug}', function (\Illuminate\Http\Request $request, string $slug) {
    $queryString = $request->getQueryString();
    $target = '/vi/' . $slug . ($queryString ? '?' . $queryString : '');
    return redirect($target, 301);
})->where('slug', '^(?!vi$|en$|admin|api|login|customer|payment|up|docs|huong-dan-su-dung|bien-ban-ban-giao)[a-zA-Z0-9\-_]+$');


