<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get the correct image path for display
     */
    public static function getDishImage($imagePath)
    {
        // If empty, return placeholder
        if (empty($imagePath)) {
            return asset('images/placeholder-dish.jpg');
        }

        // If it's a full URL
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }

        // If it's an uploaded file, serve via route
        return route('storage.file', $imagePath);
    }
}
