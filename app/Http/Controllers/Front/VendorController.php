<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
    public function dashboard()
    {
        return view('front.vendor.dashboard');
    }
}
