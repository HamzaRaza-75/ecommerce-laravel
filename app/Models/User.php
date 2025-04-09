<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Binafy\LaravelCart\Models\Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // Check if the user is a seller.
    public function isSeller()
    {
        return $this->roles()->where('name', 'store-owner')->exists();
    }

    // Check if the user is a buyer.
    public function isBuyer()
    {
        return $this->roles()->where('name', 'client')->exists();
    }

    // If the user is a seller, they may have many products.
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function userdetail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }
}
