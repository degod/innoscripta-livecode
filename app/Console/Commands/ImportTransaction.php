<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FetchTransactionService;

class ImportTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-transaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fetchTransactionService = new FetchTransactionService();
        $fetchTransactionService->doFetch();
    }
}
