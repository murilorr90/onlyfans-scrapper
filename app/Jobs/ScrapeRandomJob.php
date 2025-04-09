<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;

class ScrapeRandomJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue('scrape');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Artisan::call('scrape:random');
    }
}
