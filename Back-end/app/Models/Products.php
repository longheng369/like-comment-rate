<?php

namespace App\Models;

use App\Models\User;
use App\Models\Likes;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['image', 'header', 'title', 'price', 'details', 'category_id', 'sub_category_id', 'published_at', 'active'];

    /**
     * Define a many-to-one relationship with Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define a many-to-one relationship with SubCategory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Define a one-to-many relationship with Votes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Likes::class);
    }

    /**
     * Define a one-to-many relationship with Comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comments::class);
    }


    /**
     * Define a many-to-many relationship with User for favoritedBy.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user', 'product_id', 'user_id');
    }

    /**
     * Define a one-to-many relationship with Votes for upvotes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function upvotes(): HasMany
    {
        return $this->hasMany(Likes::class)->where('is_upvote', true);
    }

}
