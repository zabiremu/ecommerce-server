<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneBlacklist extends Model
{
    protected $fillable = ['phone', 'reason', 'blocked_by'];

    public static function isBlocked(string $phone): bool
    {
        return static::where('phone', $phone)->exists();
    }
}
