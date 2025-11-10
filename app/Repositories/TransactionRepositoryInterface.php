<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TransactionRepositoryInterface
{
    public function filter(array $filters, int $perPage, int $page, int $limit): LengthAwarePaginator;

    public function create(array $data): Transaction;

    public function findById(int $id): ?Transaction;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
