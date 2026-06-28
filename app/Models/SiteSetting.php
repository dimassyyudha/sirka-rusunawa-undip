<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    /**
     * Table
     */
    protected $table = 'site_settings';

    /**
     * Primary Key
     */
    protected $primaryKey = 'setting_id';

    public $incrementing = false;

    protected $keyType = 'string';
    protected $casts = [
        'value' => 'array',
    ];
    /**
     * Mass Assignment
     */
    protected $fillable = [
        'setting_id',
        'key',
        'value',
    ];


    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($setting) {

            if (!$setting->setting_id) {

                $last = self::orderByDesc('setting_id')->first();

                $number = $last
                    ? ((int) substr($last->setting_id, 3)) + 1
                    : 1;

                $setting->setting_id =
                    'SET' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }
        });
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */

    public static function getValue($key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function setValue($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
    public static function putValue($key, $value)
    {
        return static::setValue($key, $value);
    }
}
