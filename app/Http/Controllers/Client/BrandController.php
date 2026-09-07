<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Contracts\View\View;

class BrandController extends Controller
{
    public function index(string $locale): View
    {
        $brands = Brand::query()
            ->where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        return view('client.pages.brands', [
            'brands' => $brands,
        ]);
    }
}
