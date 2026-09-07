<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class SolutionController extends Controller
{
    public function index(string $locale): View
    {
        return view('client.pages.solutions');
    }
}
