<?php

namespace App\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Monolog\Logger;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FinancialWarningsHandler extends AbstractProcessingHandler
{
    public function __construct($level = Logger::ERROR, bool $bubble = true)
    {
        // Always call the parent constructor in Monolog 3
        parent::__construct($level, $bubble);
    }

    protected function write(array|LogRecord $record): void
    {
        $context = $record instanceof LogRecord ? $record->context : ($record['context'] ?? []);

        if (isset($context['id'])) {
            $this->notifyExternalApi($context['id'], $context);
        }
    }

    protected function notifyExternalApi($recordId, array $context = []): void
    {
        $url = rtrim(env('FINANCIAL_WARNINGS_API_URL'), '/') . '/' . $recordId . '/report';

        try {
            Http::timeout(5)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('FINANCIAL_WARNINGS_BEARER_TOKEN'),
                ])
                ->post($url, []);

            Log::channel('stack')->info('External API notified for invalid transaction', [
                'record_id' => $recordId,
            ]);
        } catch (\Throwable $e) {
            Log::channel('stack')->error('Failed to notify external API', [
                'record_id' => $recordId,
                'error'     => $e->getMessage(),
            ]);
        }
    }
}
