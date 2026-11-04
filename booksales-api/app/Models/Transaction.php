<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'book_id',
        'quantity',
        'total_amount',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
        ];
    }

    // customer_id -> users.id (nama relasi "user", foreign key-nya dituliskan manual)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
