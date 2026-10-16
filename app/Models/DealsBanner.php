<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealsBanner extends Model
{
    /**
     * Admins enter the sale start/end in shop-local time (Bangladesh);
     * the values are stored in UTC like every other timestamp.
     */
    public const LOCAL_TZ = 'Asia/Dhaka';

    protected $table = 'deals_banner';

    protected $fillable = [
        'emoji',
        'title',
        'title_highlight',
        'description',
        'button_text',
        'button_link',
        'starts_at',
        'ends_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status'    => 'boolean',
            'starts_at' => 'datetime',
            'ends_at'   => 'datetime',
        ];
    }

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'title' => 'Limited Time',
            'status' => true,
        ]);
    }

    /**
     * True while the sale countdown is running: enabled, has an end time in
     * the future, and the (optional) start time has already passed.
     */
    public function isLive(): bool
    {
        if (!$this->status || !$this->ends_at || $this->ends_at->isPast()) {
            return false;
        }

        return !$this->starts_at || $this->starts_at->lte(now());
    }

    /** The banner to show on the homepage hero, or null when no sale is running. */
    public static function live(): ?self
    {
        $banner = static::find(1);

        return $banner && $banner->isLive() ? $banner : null;
    }

    /** Human-readable state for the admin screen. */
    public function countdownState(): string
    {
        if (!$this->ends_at) return 'no-timer';
        if (!$this->status) return 'disabled';
        if ($this->ends_at->isPast()) return 'ended';
        if ($this->starts_at && $this->starts_at->isFuture()) return 'scheduled';
        return 'live';
    }
}
