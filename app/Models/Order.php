<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUSES = ['pending', 'paid', 'processing', 'completed', 'cancelled'];

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'payment_type',
        'snap_token',
        'midtrans_transaction_id',
        'paid_at',
        'total_amount',
        'customer_name',
        'phone',
        'shipping_address',
        'notes',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->latest();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function isPaid(): bool
    {
        return $this->paid_at !== null;
    }
}
