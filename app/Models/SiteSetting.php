<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'array',
    ];

    public static function getValue(string $key, array $default = []): array
    {
        $row = static::where('key', $key)->first();

        if (! $row || ! is_array($row->value)) return $default;

        return array_merge($default, $row->value);
    }

    public static function setValue(string $key, array $value): void
    {
        $row = static::firstOrNew(['key' => $key]);

        $current = is_array($row->value) ? $row->value : [];

        $row->value = array_merge($current, $value);
        $row->save();
    }

    // REPLACE total (bukan merge) biar delete slide bener-bener hilang
    public static function putValue(string $key, array $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
