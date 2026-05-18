<?php

use App\Models\SiteSetting;

function site_setting($key, $default = null)
{
    static $settings;

    if (!$settings) {
        $settings = \App\Models\SiteSetting::pluck('value', 'key');
    }

    return $settings[$key] ?? $default;
}
