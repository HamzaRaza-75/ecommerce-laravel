<?php

namespace App\Models;

use App\Models\Scopes\ActiveProducts;
use App\Models\Scopes\DescScope;
use App\Models\Scopes\LowQuantity;
use Binafy\LaravelCart\Cartable;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


#[ScopedBy(DescScope::class)]
#[ScopedBy(ActiveProducts::class)]
#[ScopedBy(LowQuantity::class)]
class Product extends Model implements Cartable
{
    //
    protected $fillable = [
        'seller_id',
        'store_id',
        'category_id',
        'name',
        'description',
        'product_image',
        'price',
        'stock',
        'status',
    ];

    public function getPrice(): float
    {
        return $this->price;
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }


    // all scopes
    public function scopeUserProducts(Builder $query)
    {
        return $query->where('seller_id', auth()->user()->id);
    }

    // shop product scopes are starting here


    public function scopeCategory(Builder $query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Scope to filter products by price range
    public function scopePriceRange(Builder $query, $minPrice, $maxPrice)
    {
        return $query->where('price', '>=', $minPrice)
            ->where('price', '<=', $maxPrice);
    }

    // Scope to search products by name
    public function scopeSearch(Builder $query, $searchTerm)
    {
        return $query->where('name', 'like', '%' . $searchTerm . '%');
    }

    // shop product scopes are ending here
}
