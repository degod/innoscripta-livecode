<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepositoryInterface;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __construct(private TransactionRepositoryInterface $transactionRepository, private ResponseService $responseService) {}

    public function __invoke(Request $request)
    {
        $this->transactionRepository->delete($request->route('id'));

        return $this->responseService->success(200, 'Transaction deleted successfully');
    }
}
