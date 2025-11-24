<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Product;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)->latest()->get();
        $products = Product::where('status', 'available')->latest()->take(6)->get();
        $contents = Content::latest()->get();
        $user = Auth::user();


        return view('members.home', compact('sliders', 'products', 'contents', 'user'));
    }
}