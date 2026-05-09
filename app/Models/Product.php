<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','price','description','published_at'];

    protected $casts = [
        'published_at' => 'datetime',
        'price'        => 'integer',
    ];

    public function getPriceFormattedAttribute(): string
    {
        return '¥'.number_format($this->price);
    }

    public function scopePublished($q)
    {
        return $q->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
