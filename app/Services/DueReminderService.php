<?php

namespace App\Services;

use App\Models\AdminNotification;
use App\Models\DealsBanner;
use App\Models\Order;
use App\Models\SiteSetting;
use App\Support\Money;
use Illuminate\Support\Carbon;

/**
 * Month-end due reminder: on the last day of each month (Bangladesh time)
 * the admins get one bell notification listing how much customers owe.
 *
 * Runs from the scheduler (dues:month-end-reminder) and, as a fallback for
 * hosting without a cron job, whenever an admin opens the dashboard. It is
 * sent at most once per month either way.
 */
class DueReminderService
{
    private const SETTING_KEY = 'due_reminder_last_month';

    /** Sends the reminder if it is due and not sent yet. Returns true when sent. */
    public static function sendIfDue(?Carbon $now = null, bool $force = false): bool
    {
        $now = ($now ?? now())->copy()->setTimezone(DealsBanner::LOCAL_TZ);

        // Month being closed: this month on its last day; or last month if
        // nobody opened the panel on that day (catch-up within 3 days).
        if ($now->isLastOfMonth() || $force) {
            $period = $now->format('Y-m');
        } elseif ($now->day <= 3) {
            $period = $now->copy()->subMonthNoOverflow()->format('Y-m');
        } else {
            return false;
        }

        if (!$force && SiteSetting::where('key', self::SETTING_KEY)->value('value') === $period) {
            return false;
        }

        $open = Order::query()->withOpenDue()->whereNotNull('customer_id');
        $total = (float) (clone $open)->sum('due_amount');
        $customers = (int) (clone $open)->distinct('customer_id')->count('customer_id');

        SiteSetting::updateOrCreate(['key' => self::SETTING_KEY], ['value' => $period, 'group' => 'system']);
        SiteSetting::flushCache();

        if ($customers === 0) {
            return false;   // nothing owed — no point pinging anyone
        }

        $overdue = (float) (clone $open)->where('due_date', '<', $now->toDateString())->sum('due_amount');
        $monthName = Carbon::createFromFormat('Y-m', $period)->format('F');

        AdminNotification::create([
            'type'    => 'due_reminder',
            'title'   => "Month-end dues ({$monthName}): " . Money::format($total),
            'message' => $customers . ' ' . ($customers === 1 ? 'customer owes' : 'customers owe') . ' ' . Money::format($total)
                . ($overdue > 0 ? ' — ' . Money::format($overdue) . ' overdue' : '')
                . '. Open the due list to collect.',
            'link'    => '/admin/dues',
        ]);

        return true;
    }
}
