<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function index(string $locale): View
    {
        return view('client.pages.about');
    }
}
