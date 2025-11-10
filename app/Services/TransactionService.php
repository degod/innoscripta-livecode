<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Transaction;

class TransactionService
{
    public function createTransaction(array $data)
    {
        Transaction::create([
            'invoice_id' => $data['invoice_id'],
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'transaction_date' => $data['transaction_date'],
            'type' => $data['type'],
            'reference_code' => $data['reference_code'],
            'details' => $data['details'],
        ]);
    }
}
