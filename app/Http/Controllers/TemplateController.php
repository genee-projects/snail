<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class TemplateController extends Controller
{
    public function index() {
        return view('templates/index');
    }

}