<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\AbsensiOtomatisService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(fn () => app(AbsensiOtomatisService::class)->tutupAbsensiYangBelumPulang())
    ->dailyAt('18:00')
    ->name('absensi-pulang-otomatis')
    ->withoutOverlapping();
