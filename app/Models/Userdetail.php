<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userdetail extends Model
{
    protected $fillable = [
        'user_id',
        'phone_number',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'profile_photo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
