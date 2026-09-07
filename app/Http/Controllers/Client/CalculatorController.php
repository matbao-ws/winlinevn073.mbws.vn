<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Catalog\ProductQueryService;
use Illuminate\Contracts\View\View;

class CalculatorController extends Controller
{
    public function __construct(
        private readonly ProductQueryService $products,
    ) {}

    public function index(string $locale): View
    {
        $recommendedProducts = $this->products
            ->listing(['sort_by' => 'latest'])
            ->take(6)
            ->get();

        return view('client.pages.calculator', [
            'recommendedProducts' => $recommendedProducts,
        ]);
    }
}
