<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class InvalidTransactionException extends Exception
{
    public function __construct(
        public int|string $recordId,
        string $message = 'Invalid transaction detected.',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
