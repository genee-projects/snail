<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use App\Product;
use App\Server;
use App\Project;

class DashboardController extends Controller
{
    public function index() {

        \App\Gini\Gapper\Client::init();

        if (\App\Gini\Gapper\Client::getUserName()) {
            return view('dashboard', [
                'products_count'=> Product::count(),
                'servers_count'=> Server::count(),
                'clients_count'=> Client::where('parent_id', 0)->count(),
                'projects_count'=> Project::count(),
            ]);
        }


        return view('login');
    }
}
