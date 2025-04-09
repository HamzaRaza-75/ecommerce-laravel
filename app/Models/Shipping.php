<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = [
        'order_id',
        'shipping_method',
        'shipping_cost',
        'tracking_number',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
