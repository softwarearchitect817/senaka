<?php

if (!function_exists('getSetting')) {
    /**
     * @param array|string|null $meta_key
     * @return array|string|null
     */

    function getSetting($meta_key = null) {
        $setting = [];
        switch (gettype($meta_key)) {
            case 'string':
                $value = \App\Models\StockSetting::where('meta_key', $meta_key)->first();
                $setting = empty($value) ? null : $value->meta_value;
                break;
            case 'array':
                $metas = \App\Models\StockSetting::whereIn('meta_key', $meta_key)->pluck('meta_value', 'meta_key');
                foreach ($meta_key as $key) {
                    $setting[$key] = empty($metas[$key]) ? null : $metas[$key];
                }
                break;
            default :
                $setting = \App\Models\StockSetting::pluck('meta_value', 'meta_key');
        }
        return $setting;
    }
}

if (!function_exists('updateSetting')) {
    /**
     * @param array|string $meta_key
     * @param string|null $meta_value
     */
    function updateSetting($meta_key, $meta_value = null) {
        if (gettype($meta_key) == 'array') {
            foreach ($meta_key as $key => $value) {
                \App\Models\StockSetting::updateOrCreate([
                    'meta_key' => $key,
                ], [
                    'meta_value' => $value,
                ]);
            }
        } else {
            \App\Models\StockSetting::updateOrCreate([
                'meta_key' => $meta_key,
            ], [
                'meta_value' => $meta_value,
            ]);
        }
    }
}