<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use App\Project;
use App\Client;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('projects/index', ['projects'=> Project::all()]);
    }

    public function add(Request $request) {

        $product = Product::find($request->input('product_id'));
        $client = Client::find($request->input('client_id'));

        $project = new Project();
        $project->product()->associate($product);
        $project->client()->associate($client);

        $project->name = $request->input('name');
        $project->seller = $request->input('seller');
        $project->contact = $request->input('contact');
        $project->time = $request->input('time');
        $project->description = $request->input('description');

        if ($project->save()) {
            return redirect('/');
        }
    }

    public function profile($id) {
        
        $project = Project::find($id);

        return view('/projects/profile', ['project'=> $project]);
    }

}
