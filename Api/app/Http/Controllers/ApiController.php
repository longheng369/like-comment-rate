<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        $products = Products::with(['votes','comments','rate'])
        ->withCount([
            'votes as upvotes_count' => function ($query){
                $query->where('is_upvote',true);
            },
            'votes as downvotes_count' => function ($query){
                $query->where('is_upvote',false);
            }
        ])->get()
        ->map(function ($product){
            $vote = $product->votes->first(function ($vote){
                return $vote->is_upvote;
            });

            return [
                'id' => $product->id,
                'image' => $product->image,
                'header' => $product->header,
                'title' => $product->title,
                'price' => $product->price,
                'details' => $product->details,
                'quantity' => $product->quantity,
                'scale' => $product->scale,
                'category_type' => $product->category_type,
                'published_at' => $product->published_at,
                'active' => $product->active,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'upvotes_counts' => $product->upvotes_count,
                'downvote_counts' => $product->downvotes_count,
                'vote' => $vote,
                'comments' => $product->comments->isNotEmpty() ? $product->comments->first()->body: null,
                'rate' => $product->rate->isNotEmpty() ? $product->rate->first()->rate : null,
            ];

        });
        return response()->json(['data' => $products]);
    }
}
