<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule daily backup if enabled
Schedule::command('backup:run')->dailyAt('02:00')->when(function () {
    return config('student_portal.backup.automatic_backup', true);
});

// Schedule cache cleanup
Schedule::command('cache:prune-stale-tags')->hourly();

// Schedule error log cleanup
Schedule::call(function () {
    // Clean up old error logs based on retention policy
    $retentionDays = config('student_portal.logging.retention_days', 90);
    \App\Models\SystemErrorLogs::where('created_at', '<', now()->subDays($retentionDays))->delete();
})->daily()->name('cleanup-error-logs');

// Schedule session cleanup
Schedule::command('session:gc')->daily();
