<?php

namespace App\Models;

use App\Models\Scopes\DescScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;


#[ScopedBy(DescScope::class)]
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'product_price',
        'total_price',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'order_item_id');
    }

    public function canBeReviewedBy(User $user, Product $product)
    {
        return Review::where('user_id', $user->id)
            ->where('order_id', $this->id)
            ->where('product_id', $product->id)
            ->doesntExist();
    }
}
