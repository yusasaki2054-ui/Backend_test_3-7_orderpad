<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id','order_date','total_amount'];

    protected $casts = [
        'order_date'   => 'date',
        'total_amount' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getComputedTotalAttribute(): int
    {
        if (! $this->relationLoaded('items')) {
            return 0;
        }
        return $this->items->sum(fn($i) => $i->qty * $i->unit_price);
    }

    public function scopeWithin($q, ?string $from, ?string $to)
    {
        return $q->when($from, fn($qq) => $qq->where('order_date','>=',$from))
                 ->when($to,   fn($qq) => $qq->where('order_date','<=',$to));
    }

    public function scopeOfUser($q, ?int $userId)
    {
        return $q->when($userId, fn($qq) => $qq->where('user_id', $userId));
    }
}
