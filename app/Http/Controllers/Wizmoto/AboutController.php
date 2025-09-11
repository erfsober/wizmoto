<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Brand;
use App\Models\Faq;

class AboutController extends Controller
{
    public function index()
    {
        $aboutSections = AboutUs::where('is_active', true)
            ->orderBy('sort')
            ->get();
            $popularBrands = Brand::query()
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Get recent FAQs for the about page
        $recentFaqs = Faq::where('is_active', true)
            ->orderBy('sort')
            ->take(5)
            ->get();

        return view('wizmoto.about.index', compact('aboutSections', 'popularBrands',
        'recentFaqs'));
    }
}
