<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\CreateRequest;
use App\Repositories\TransactionRepositoryInterface;
use App\Services\ResponseService;

class CreateController extends Controller
{
    public function __construct(private TransactionRepositoryInterface $transactionRepository, private ResponseService $responseService) {}

    public function __invoke(CreateRequest $request)
    {
        $data = $request->only(['amount', 'invoice_id', 'description', 'currency', 'transaction_date', 'type', 'reference_code', 'details']);

        $transaction = $this->transactionRepository->create($data);

        return $this->responseService->success(201, 'Transaction created successfully', $transaction);
    }
}
