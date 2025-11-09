<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'is_editable',
        'is_sensitive'
    ];

    protected $casts = [
        'is_editable' => 'boolean',
        'is_sensitive' => 'boolean'
    ];

    /**
     * Get setting value with type conversion
     */
    public function getTypedValue()
    {
        return match($this->type) {
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'number' => is_numeric($this->value) ? (float)$this->value : 0,
            'json' => json_decode($this->value, true),
            default => $this->value
        };
    }

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        $cacheKey = "system_setting_{$key}";
        
        return Cache::remember($cacheKey, 3600, function() use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->getTypedValue() : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value, string $type = 'string'): self
    {
        $valueString = match($type) {
            'boolean' => $value ? '1' : '0',
            'json' => is_string($value) ? $value : json_encode($value),
            default => (string)$value
        };

        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $valueString, 'type' => $type]
        );

        Cache::forget("system_setting_{$key}");
        
        return $setting;
    }

    /**
     * Get all settings grouped
     */
    public static function getAllGrouped(): array
    {
        $settings = self::orderBy('group')->orderBy('label')->get();
        
        return $settings->groupBy('group')->map(function($group) {
            return $group->map(function($setting) {
                return [
                    'id' => $setting->id,
                    'key' => $setting->key,
                    'value' => $setting->is_sensitive ? '***' : $setting->value,
                    'typed_value' => $setting->is_sensitive ? null : $setting->getTypedValue(),
                    'type' => $setting->type,
                    'label' => $setting->label,
                    'description' => $setting->description,
                    'is_editable' => $setting->is_editable,
                    'is_sensitive' => $setting->is_sensitive
                ];
            });
        })->toArray();
    }
}

