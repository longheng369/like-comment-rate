<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    // all data 
    public function index(Request $request)
    {
        $products = Products::with(['votes', 'comments.user', 'rate'])
            ->where('active', true)
            ->withCount([
                'votes as upvotes_count' => function ($query) {
                    $query->where('is_upvote', true);
                },
                'votes as downvotes_count' => function ($query) {
                    $query->where('is_upvote', false);
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
                    'upvotes_counts' => $product->upvotes_count,
                    'downvote_counts' => $product->downvotes_count,

                    'votes' => $product->votes, // Assuming you handle votes similarly
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

    // new arrival
    public function newArrival1(Request $request){
        // Get current time
        $now = Carbon::now();

        // Query to get the 5 latest products
        $products = Products::with(['votes','comments','rate'])
            ->where('active', true)
            // Add a condition to filter products created recently, if needed
            // For example, to get products created within the last 30 days
            // ->where('created_at', '>', $now->subDays(30))
            ->orderBy('created_at', 'desc') // Order by creation time, newest first
            ->take(5) // Limit to 5
            ->withCount([
                'votes as upvotes_count' => function ($query) {
                    $query->where('is_upvote', true);
                },
                'votes as downvotes_count' => function ($query) {
                    $query->where('is_upvote', false);
                }
            ])->get()
            ->map(function ($product) {
                $vote = $product->votes->first(function ($vote) {
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
                    'rates' => $product->rate,
                ];

            });
        return response()->json(['data' => $products]);
    }

    public function getIsLiked()
    {
        $userId = auth()->id();
        // Fetch products liked by the specified user
        $likedProducts = Products::with(['votes', 'comments.user', 'rate'])
        ->whereHas('votes', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->where('is_upvote', true);
        })
        ->where('active', true)
        ->withCount([
            'votes as upvotes_count' => function ($query) {
                $query->where('is_upvote', true);
            },
            'votes as downvotes_count' => function ($query) {
                $query->where('is_upvote', false);
            }
        ])->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                // 'image' => $product->image,
                // 'header' => $product->header,
                // 'title' => $product->title,
                // 'price' => $product->price,
                // 'details' => $product->details,
                // 'quantity' => $product->quantity,
                // 'scale' => $product->scale,
                // 'category_type' => $product->category_type,
                // 'published_at' => $product->published_at,
                // 'active' => $product->active,
                // 'created_at' => $product->created_at,
                // 'updated_at' => $product->updated_at,
                // 'upvotes_counts' => $product->upvotes_count,
                // 'downvote_counts' => $product->downvotes_count,
                // 'votes' => $product->votes,
                // 'comments' => $product->comments->map(function ($comment) {
                //     return [
                //         'body' => $comment->body,
                //         'user_name' => $comment->user->name,
                //     ];
                // }),

            ];
        });

        return response()->json(['data' => $likedProducts]);
    }
    
    
} 
