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
    protected $signature = 'app:import-transaction {--page=1} {--limit=100}';

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
        $page = $this->option('page') ?? 1;   // default to 1
        $limit = $this->option('limit') ?? 100; // default to 100

        $this->info("Importing transactions (page: $page, limit: $limit)...");

        $fetchTransactionService = new FetchTransactionService();
        $fetchTransactionService->doFetch($page, $limit);
    }
}
