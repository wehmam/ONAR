<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home() {
        return view('frontend.pages.home');
    }

    public function profile() {
        return view('frontend.pages.profile');
    }
}
