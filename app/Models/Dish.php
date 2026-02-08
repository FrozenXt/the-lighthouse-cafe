<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Dish extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'featured_type',
        'category_id',
        'rating',
        'is_available'
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'rating'       => 'decimal:1',
        'is_available' => 'boolean'
    ];

    /* =========================
     | Relationships
     ========================= */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /* =========================
     | Accessors
     ========================= */

    /**
     * Get full image URL
     * - External URL → returned as-is
     * - Uploaded image → /storage/...
     * - Missing image → placeholder
     */
    public function getImageUrlAttribute()
    {
        // No image stored
        if (!$this->image) {
            return asset('images/placeholder-dish.jpg');
        }

        // External image
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Local uploaded image
        return Storage::url($this->image);
    }
}
