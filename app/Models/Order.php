<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    const ORDER_CREATED   = 'created';
    const ORDER_PAID      = 'paid';
    const ORDER_SHIPPED   = 'shipped';
    const ORDER_DELIVERED = 'delivered';
    const ORDER_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'cart_id',
        'total_amount',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function shipping(): HasOne
    {
        return $this->hasOne(Shipping::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
