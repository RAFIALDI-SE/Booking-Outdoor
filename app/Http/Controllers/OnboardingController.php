<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Product;
use App\Models\Content;

class OnboardingController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)->latest()->get();
        $products = Product::where('status', 'available')->latest()->take(6)->get();
        $contents = Content::latest()->get();

        // lokasi bisa diambil dari tabel settings atau sementara statis dulu
        $location = [
            'name' => 'Outdoor Adventure Center',
            'address' => 'Jl. Gunung Merapi No. 45, Sleman, Yogyakarta',
            'map_link' => 'https://maps.google.com/?q=-7.769,110.378'
        ];

        return view('welcome', compact('sliders', 'products', 'contents', 'location'));
    }


}