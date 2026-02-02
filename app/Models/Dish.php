<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Dish extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'featured_type',
        'category',
        'rating',
        'is_available'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_available' => 'boolean'
    ];

    // Add this relationship
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
