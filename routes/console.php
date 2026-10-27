<?php

use App\Services\DatabaseBackupService;
use App\Services\DueReminderService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Month-end customer due reminder (admin bell notification).
Artisan::command('dues:month-end-reminder {--force : Send now even if it is not month-end}', function () {
    $sent = DueReminderService::sendIfDue(null, (bool) $this->option('force'));
    $this->info($sent ? 'Due reminder sent.' : 'Nothing to send (not month-end, already sent, or no dues).');
})->purpose('Notify admins of outstanding customer dues at month-end');

// Checked daily; the service only sends on the last day of the month (once).
Schedule::command('dues:month-end-reminder')->dailyAt('10:00')->timezone('Asia/Dhaka');

// Daily database backup (storage/app/backups, newest 30 kept).
Artisan::command('backup:run', function (DatabaseBackupService $backups) {
    $this->info('Backup created: ' . $backups->create('auto'));
})->purpose('Back up the database');

Schedule::command('backup:run')->dailyAt('02:00')->timezone('Asia/Dhaka');
