<?php

namespace App\Models;

use App\Models\Scopes\DescScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(DescScope::class)]
class Order extends Model
{

    protected $with = ['orderitems'];

    protected $fillable = [
        'user_id',
        'order_num',
        'status',
        'total_amount',
        'discount_amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipping::class);
    }



    // scopes for order controller

    public function scopeStatus(Builder $query, $status)
    {
        return $query->when($status, fn($q) => $q->where('status', $status));
    }

    // Scope for filtering by date range
    public function scopeDateRange(Builder $query, $from, $to)
    {
        return $query->when($from && $to, fn($q) => $q->whereBetween('created_at', [$from, $to]));
    }
}
