<?php

namespace App\Models;

use App\Models\Scopes\DescScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(DescScope::class)]
class Store extends Model
{
    //
    protected $fillable = ['user_id', 'category_id', 'name', 'description', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
