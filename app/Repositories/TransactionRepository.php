<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Transaction $transactionModel) {}

    public function filter(array $filters, int $perPage, int $page, int $limit): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = $this->transactionModel->newQuery();

        $query->when($filters['date_from'] ?? null, function ($q, $from) {
            $q->whereDate('transaction_date', '>=', $from);
        })->when($filters['date_to'] ?? null, function ($q, $to) {
            $q->whereDate('transaction_date', '<=', $to);
        });

        if (! $limit) {
            return $query->paginate($perPage, ['*'], 'page', $page);
        }

        $baseQuery = clone $query;
        $totalMatching = (int) $baseQuery->toBase()->getCountForPagination();
        $total = min($totalMatching, $limit);

        $offset = ($page - 1) * $perPage;
        if ($offset >= $limit) {
            $items = collect();
        } else {
            $take = min($perPage, $limit - $offset);
            $items = $query->offset($offset)->limit($take)->get();
        }

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path'  => request()->url(),
                'query' => request()->query(),
            ]
        );
    }

    public function create(array $data): Transaction
    {
        return $this->transactionModel->create($data);
    }

    public function findById(int $id): ?Transaction
    {
        return $this->transactionModel->find($id);
    }

    public function update(int $id, array $data): bool
    {
        $transaction = $this->findById($id);
        if ($transaction) {
            return $transaction->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $transaction = $this->findById($id);
        if ($transaction) {
            return $transaction->delete();
        }
        return false;
    }
}
