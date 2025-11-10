<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class LogFinancialWarning implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(public string $message) {}

    public function handle(): void
    {
        Log::channel('financial_warnings')->warning($this->message);
    }
}
