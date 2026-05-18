<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            // General
            'site_name'              => 'nullable|string|max:255',
            'site_tagline'           => 'nullable|string|max:255',
            'site_description'       => 'nullable|string|max:500',
            'footer_text'            => 'nullable|string|max:255',
            'currency_symbol'        => 'nullable|string|max:10',

            // Location
            'restaurant_lat'         => 'nullable|numeric|between:-90,90',
            'restaurant_lng'         => 'nullable|numeric|between:-180,180',
            'restaurant_address'     => 'nullable|string|max:500',
            'google_maps_url'        => 'nullable|url|max:1000',
            'delivery_radius_km'     => 'nullable|integer|min:1|max:100',

            // Branding — files
            'site_logo'              => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'site_favicon'           => 'nullable|image|mimes:png,ico,jpg|max:1024',

            // Branding — colors
            'color_primary'          => 'nullable|string|max:7',
            'color_secondary'        => 'nullable|string|max:7',
            'color_accent'           => 'nullable|string|max:7',

            // Delivery
            'delivery_fee'           => 'nullable|numeric|min:0',
            'free_delivery_above'    => 'nullable|numeric|min:0',
            'min_order_amount'       => 'nullable|numeric|min:0',
            'delivery_time_estimate' => 'nullable|string|max:50',
            'tax_rate'               => 'nullable|numeric|min:0|max:100',
            'order_prefix'           => 'nullable|string|max:20',

            // Contact & Social
            'contact_email'          => 'nullable|email|max:255',
            'contact_phone'          => 'nullable|string|max:50',
            'social_instagram'       => 'nullable|url|max:500',
            'social_facebook'        => 'nullable|url|max:500',
            'social_twitter'         => 'nullable|url|max:500',
            'social_tiktok'          => 'nullable|url|max:500',

            // Hours — validated loosely; the loop below handles all days
            'hours_monday_from'      => 'nullable|date_format:H:i',
            'hours_monday_to'        => 'nullable|date_format:H:i',
            // (full per-day validation handled in the loop)
        ]);

        // ── 1. Plain text / numeric settings ──────────────────────────────
        $textSettings = [
            // General
            'site_name',
            'site_tagline',
            'site_description',
            'footer_text',
            'currency_symbol',

            // Location
            'restaurant_lat',
            'restaurant_lng',
            'restaurant_address',
            'google_maps_url',
            'delivery_radius_km',

            // Branding colors
            'color_primary',
            'color_secondary',
            'color_accent',

            // Delivery
            'delivery_fee',
            'free_delivery_above',
            'min_order_amount',
            'delivery_time_estimate',
            'tax_rate',
            'order_prefix',

            // Contact & social
            'contact_email',
            'contact_phone',
            'social_instagram',
            'social_facebook',
            'social_twitter',
            'social_tiktok',
        ];

        foreach ($textSettings as $key) {
            SiteSetting::set($key, $request->input($key));
        }

        // ── 2. File uploads ────────────────────────────────────────────────
        $fileSettings = ['site_logo', 'site_favicon'];

        foreach ($fileSettings as $key) {
            if ($request->hasFile($key)) {
                // Delete old file if it exists
                $old = SiteSetting::get($key);
                if ($old) {
                    Storage::disk('public')->delete($old);
                }

                $path = $request->file($key)->store('settings', 'public');
                SiteSetting::set($key, $path, 'image');
            }
        }

        // ── 3. Opening hours ───────────────────────────────────────────────
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($days as $day) {
            // Checkbox: present = 1, absent = 0
            SiteSetting::set("hours_{$day}_open", $request->boolean("hours_{$day}_open") ? '1' : '0');
            SiteSetting::set("hours_{$day}_from", $request->input("hours_{$day}_from", '09:00'));
            SiteSetting::set("hours_{$day}_to",   $request->input("hours_{$day}_to",   '22:00'));
        }

        // ── 4. Feature toggles ─────────────────────────────────────────────
        $features = [
            'feature_online_ordering',
            'feature_stripe_payments',
            'feature_cash_on_delivery',
            'feature_reservations',
            'feature_reviews',
            'feature_maintenance_mode',
        ];

        foreach ($features as $feature) {
            // Unchecked checkboxes are not submitted, so default to '0'
            SiteSetting::set($feature, $request->boolean($feature) ? '1' : '0');
        }

        return back()->with('success', 'Settings updated successfully');
    }
}
