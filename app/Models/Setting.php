<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        switch ($setting->type) {
            case 'boolean':
                return (bool) $setting->value;
            case 'number':
                return is_numeric($setting->value) ? (float) $setting->value : $default;
            case 'json':
                return json_decode($setting->value, true);
            default:
                return $setting->value;
        }
    }

    /**
     * Set a setting value by key
     */
    public static function set($key, $value, $type = 'string', $description = null)
    {
        $setting = static::where('key', $key)->first();
        
        if ($setting) {
            $setting->update([
                'value' => $value,
                'type' => $type,
                'description' => $description,
            ]);
        } else {
            static::create([
                'key' => $key,
                'value' => $value,
                'type' => $type,
                'description' => $description,
            ]);
        }
        
        return $setting;
    }
}