<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $comment = new Comment();

        $object_name = ucwords($request->input('object_type'));
        $object_id = $request->input('object_id');

        $object = $object_name::find($object_id);

        $comment->object()->associate($object);
        $comment->content = $request->input('content');

        $comment->save();

        return redirect()->back()
            ->with('message_content', '备注成功!')
            ->with('message_type', 'info');
    }
}
