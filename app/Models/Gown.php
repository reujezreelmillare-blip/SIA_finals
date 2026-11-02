<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gown extends Model
{
    protected $fillable = [
        'name',
        'category',
        'description',
        'size',
        'color',
        'rental_price',
        'deposit_price',
        'image',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}