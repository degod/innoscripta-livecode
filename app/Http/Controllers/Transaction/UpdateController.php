<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\UpdateRequest;
use App\Repositories\TransactionRepositoryInterface;
use App\Services\ResponseService;

class UpdateController extends Controller
{
    public function __construct(private TransactionRepositoryInterface $transactionRepository, private ResponseService $responseService) {}

    public function __invoke(UpdateRequest $request, int $id)
    {
        $data = $request->only(['amount', 'invoice_id', 'description', 'currency', 'transaction_date', 'type', 'reference_code', 'details']);

        $transaction = $this->transactionRepository->update($id, $data);
        return $this->responseService->success(200, 'Transaction updated successfully', $transaction);
    }
}
