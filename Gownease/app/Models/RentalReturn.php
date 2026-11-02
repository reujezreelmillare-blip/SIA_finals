<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalReturn extends Model
{
    protected $fillable = [
        'booking_id',
        'returned_at',
        'condition',
        'late_fee',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'returned_at' => 'date',
            'late_fee' => 'decimal:2',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
