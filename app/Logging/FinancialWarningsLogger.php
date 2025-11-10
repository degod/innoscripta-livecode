<?php

namespace App\Logging;

use Monolog\Logger;

class FinancialWarningsLogger
{
    public function __invoke(array $config)
    {
        $logger = new Logger('financial_warnings');
        $logger->pushHandler(new FinancialWarningsHandler());
        return $logger;
    }
}
