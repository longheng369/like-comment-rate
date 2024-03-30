<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Products;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comments::all();

        return response()->json(['comments' => $comments]);
    }

    public function store(Request $request, Products $product)
    {
        $request->validate([
            'body'=>'required|string'
        ]);

        $comment = Comments::create([
            'product_id' => $product->id,
            'user_id' => $request->user()->id,
            'body'=> $request->body
        ]);

        return response()->json($comment,201);
    }
}
