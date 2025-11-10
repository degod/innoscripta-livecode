<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepositoryInterface;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class FetchController extends Controller
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
        private ResponseService $responseService
    ) {}

    public function __invoke(Request $request)
    {
        $filters = $request->filters ?? [];
        $perPage = $request->perPage ?? 15;
        $page = $request->page ?? 1;
        $limit = $request->limit ?? 10;

        $paginator = $this->transactionRepository->filter($filters, $perPage, $page, $limit);

        return $this->responseService->successPaginated($paginator, 'Transactions retrieved successfully', 200);
    }
}
