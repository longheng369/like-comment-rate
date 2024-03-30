<?php

namespace App\Models;

use App\Models\Rate;
use App\Models\Votes;
use App\Models\Comments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['image','header','title','price','details','quantity','scale','category_type','published_at','active'];

    public function votes()
    {
        return $this->hasMany(Votes::class, 'product_id');
    }
    
    public function upvotes()
    {
        return $this->hasMany(Votes::class)->where('is_upvote',true);
    }

    public function downvotes()
    {
        return $this->hasMany(Votes::class)->where('is_upvote',false);
    }


    public function comments()
    {
        return $this->hasMany(Comments::class, 'product_id');
    }

    public function rate()
    {
        return $this->hasMany(Rate::class, 'product_id');
    }


}
