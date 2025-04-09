<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;

class ScrapeUserJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    private string $username;

    /**
     * Create a new job instance.
     */
    public function __construct(string $username)
    {
        $this->username = $username;
        $this->onQueue('scrape');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Artisan::call('scrape:user', [
            'username' => $this->username
        ]);
    }
}
