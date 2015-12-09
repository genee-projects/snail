<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comment;
use App\Client;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        //
        $comment = new Comment();

        $comment->object()->associate(Client::find(1));

        $comment->content = $request->input('content');

        $comment->save();
    }
}