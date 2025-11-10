<?php

namespace App\Services;

use App\Exceptions\InvalidTransactionException;
use App\Models\Invoice;

class InvoiceService
{
    public function createInvoiceWithTransactions(array $data)
    {
        $transactionService = new TransactionService();

        if ($data['customer_name']) {
            Invoice::create([
                'invoice_number' => $data['invoice_number'],
                'total_amount' => $data['total_amount'],
                'currency' => $data['currency'],
                'invoice_date' => $data['invoice_date'],
                'reduction_type' => $data['reduction_type'] ?? null,
                'customer_name' => $data['customer_name'],
            ]);

            if ($data['transactions']) {
            }
        } else {
            // InvalidTransactionException::report('Customer name is missing in the transaction data.');
            \Log::error('Customer name is missing in the transaction data:: ' . $data['id']);
        }
    }
}
