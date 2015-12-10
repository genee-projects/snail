<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use App\Product;
use App\Server;

class DashboardController extends Controller
{
    public function index() {
        return view('index', [
            'products_count'=> Product::count(),
            'servers_count'=> Server::count(),
            'clients_count'=> Client::count(),
        ]);
    }
}
