<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request)
    {
        $settings = SiteSetting::pluck('value', 'key');

        $restaurantLat = $settings['restaurant_lat'] ?? null;
        $restaurantLng = $settings['restaurant_lng'] ?? null;

        if (!$restaurantLat || !$restaurantLng) {
            return back()->with('error', 'Restaurant location is not configured.');
        }

        $distance = $this->calculateDistance(
            $restaurantLat,
            $restaurantLng,
            $request->latitude,
            $request->longitude
        );

        if ($distance > 10) {
            return back()->with('error', 'Delivery not available. You are too far from the restaurant.');
        }

        // continue order creation
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // KM

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
