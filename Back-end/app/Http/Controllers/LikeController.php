<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Products;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //
    public function index()
    {
        return;
    }

    protected function handleVote($user, Products $product, $upvote)
    {
        if(!$user){
            return response()->json(['message'=>'Unauthorized'],401);
        }

        $vote = Likes::firstOrNew(
            ['product_id' => $product->id, 'user_id' => $user->id],
            ['is_upvote' => $upvote]
        );

        if($vote->exists && $vote->is_upvote == $upvote){
            $vote->delete();
            $action = "remove";
        }else{
            $vote->is_upvote = $upvote;
            $vote->save();
            $action = 'added';
        }

        return response()->json(['message'=>"Vote {$action}' Successfully."], 200);
    }

    


    public function upvote(Request $request, Products $product)
    {
        return $this->handleVote($request->user(), $product,true);
    }

    public function downvote(Request $request, Products $product)
    {
        return $this->handleVote($request->user(), $product,false);
    }

    public function voteCounts(Products $product)
    {
        $upvotes = Likes::where('product_id',$product->id)->where('is_upvote',true)->count();
        $downvotes = Likes::where('product_id',$product->id)->where('is_upvote',false)->count();

        return response()->json([
            'upvotes' => $upvotes,
            'downvotes' => $downvotes,
            'productData' => $product
        ]);
    }
}
