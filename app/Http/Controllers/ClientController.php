<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function clients() {
        return view('clients/clients');
    }

    public function add() {
        return view('clients/add');
    }

    public function profile() {
        return view('clients/profile');
    }
}
