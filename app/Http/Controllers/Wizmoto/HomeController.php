<?php

namespace App\Http\Controllers\Wizmoto;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index () {
        $advertisements = Advertisement::all();

        return view('wizmoto.home.index', compact('advertisements'));
    }
}
