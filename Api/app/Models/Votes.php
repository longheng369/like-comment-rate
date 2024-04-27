<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Votes extends Model
{
    use HasFactory;

    protected $table = 'votes';

    protected $fillable = ['product_id','user_id','is_upvote'];

    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
