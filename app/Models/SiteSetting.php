<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    public const SLUG = 'site-settings';

    protected $guarded = [];

    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * The saved site settings as an array (empty if none saved yet).
     */
    public static function current(): array
    {
        return static::where('slug', static::SLUG)->first()?->settings ?? [];
    }
}
