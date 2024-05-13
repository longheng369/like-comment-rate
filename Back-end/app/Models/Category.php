<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = ['image', 'title', 'active'];


     // Define the relationship to represent the subcategories
     public function subCategories()
     {
         return $this->hasMany(SubCategory::class);
     }
}
