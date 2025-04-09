<?php

use App\Jobs\ScrapeUserJob;
use App\Models\Profile;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $profiles = Profile::where('likes', '>=', 100000)->get();

    foreach ($profiles as $profile) {
        ScrapeUserJob::dispatch($profile->username->id, $profile->username);
    }
})->daily();

Schedule::call(function () {
    $profiles = Profile::where('likes', '<', 100000)->get();

    foreach ($profiles as $profile) {
        ScrapeUserJob::dispatch($profile->username->id, $profile->username);
    }
})->cron('0 0 */3 * *');
