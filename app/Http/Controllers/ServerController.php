<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;

class ServerController extends Controller
{
    public function servers() {
        return view('index');
    }

    public function profile() {
        return view('index');
    }
}