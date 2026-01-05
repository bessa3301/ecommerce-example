<?php

use App\Jobs\NotifyLowStock;
use App\Jobs\SendDailySalesReport;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new SendDailySalesReport)->dailyAt('18:00');
Schedule::job(new NotifyLowStock)->dailyAt('09:00');
