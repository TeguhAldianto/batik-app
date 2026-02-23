<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'number',
        'total_price',
        'status',
        'shipping_address',
        'shipping_cost',
        'courier',
        'tracking_number',
        'snap_token',
    ];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Item Barang
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
