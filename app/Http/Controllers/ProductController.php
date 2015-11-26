<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;

class ProductController extends Controller
{
    public function products() {
        return view('products/products');
    }

    public function profile() {
        return view('products/profile');
    }
}