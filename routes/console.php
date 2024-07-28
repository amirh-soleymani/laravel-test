<?php

use App\Mail\ActivityUserNotification;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $tomorrow = Carbon::now()->addDays(1)->toDateString();

    $activities = Activity::where('start_date', $tomorrow)
        ->get();
    foreach ($activities as $activity) {
        foreach ($activity->book as $bookOrder) {
            Mail::to($bookOrder->user_email)
                ->queue(new ActivityUserNotification($bookOrder));
        }
    }

})->daily();
