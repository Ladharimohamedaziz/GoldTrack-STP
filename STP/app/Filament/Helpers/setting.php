<?php
// use Illuminate\Support\Facades\Cache;
// use App\Models\Setting;

// if (! function_exists('setting')) {
//     function setting($key, $default = null)
//     {
//         return Cache::remember("setting_{$key}", 60 * 60, function () use ($key, $default) {
//             $setting = Setting::where('key', $key)->first();
//             return $setting ? $setting->value : $default;
//         });
//     }
// }
