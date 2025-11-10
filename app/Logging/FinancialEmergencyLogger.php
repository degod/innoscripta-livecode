<?php

namespace App\Logging;

use Monolog\Logger;

class FinancialEmergencyLogger
{
    public function __invoke(array $config)
    {
        $logger = new Logger('financial_emergency');
        $logger->pushHandler(new FinancialEmergencyHandler());
        return $logger;
    }
}
