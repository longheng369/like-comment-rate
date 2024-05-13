<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $products = Products::with(['likes', 'comments.user'])
            ->where('active', true)
            ->orderBy('created_at', 'desc')
            ->withCount([
                'votes as upvotes_count' => function ($query) {
                    $query->where('is_upvote', true);
                }
            ])->get()
            ->map(function ($product) use ($request) {
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
                    'upvotes_count' => $product->upvotes_count,
                    

                    'votes' => $product->likes, // Assuming you handle votes similarly
                    'comments' => $product->comments->map(function ($comment) use ($request) {
                        // $user = $request->user();
                        // $isUserComment = $user ? $user->id === $comment->user_id : false;
                        return [
                            'body' => $comment->body,
                            'user_name' => $comment->user->name, // Assuming the user model has a name field
                            // Include any other relevant information
                        ];
                    }),
                ];
            });
        return response()->json(['data' => $products]);
    }
    //
    public function getItemsWithLikes(Request $request)
    {
        // Fetching all products associated with the current user
        $products = Products::with(['likes', 'comments.user'])
            ->where('active', true)
            ->orderBy('created_at', 'desc')
            ->withCount([
                'likes as upvotes_count' => function ($query) {
                    $query->where('is_upvote', true);
                },
            ])->get()
            ->map(function ($product) use ($request) {
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
                    'likes' => $product->likes, // Assuming you handle votes similarly
                    'comments' => $product->comments->map(function ($comment) use ($request) {
                        // $user = $request->user();
                        // $isUserComment = $user ? $user->id === $comment->user_id : false;
                        return [
                            'body' => $comment->body,
                            'user_name' => $comment->user->name, // Assuming the user model has a name field
                            // Include any other relevant information
                        ];
                    }),
                ];
            });

        // Fetching liked products of the user
        $likedProducts = $request->user()->likedProducts()->pluck('product_id')->toArray();

        // Fetching favorite products of the user
        $favoriteItems = $request->user()->favorites()->orderBy('products.id', 'desc')->pluck('product_id')->toArray();

        return response()->json([
            'data' => $products,
            'likedItems' => $likedProducts,
            'favoriteItems' => $favoriteItems
        ]);
    }
}
