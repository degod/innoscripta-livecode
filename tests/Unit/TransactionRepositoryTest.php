<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class TransactionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private TransactionRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        // Instantiate the repository with a fresh Transaction model
        $this->repository = new TransactionRepository(new Transaction());
    }

    public function test_it_can_filter_transactions_and_cache_results()
    {
        Cache::flush(); // Ensure cache is empty

        // Seed some fake transactions
        Transaction::factory()->create(['transaction_date' => '2025-01-01']);
        Transaction::factory()->create(['transaction_date' => '2025-01-02']);
        Transaction::factory()->create(['transaction_date' => '2025-02-01']);

        $filters = [
            'date_from' => '2025-01-01',
            'date_to'   => '2025-01-31',
        ];
        $perPage = 2;
        $page = 1;
        $limit = 5;

        // Call the filter method
        $paginator = $this->repository->filter($filters, $perPage, $page, $limit);

        // Assertions
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $paginator);
        $this->assertCount(2, $paginator->items()); // perPage = 2
        $this->assertEquals(2, $paginator->total()); // total within limit (2 matches)

        // Ensure caching works
        $cacheKey = 'transactions:' . md5(json_encode($filters) . ":page=$page:perPage=$perPage:limit=$limit");
        $this->assertTrue(Cache::has($cacheKey));
    }

    public function test_it_returns_empty_collection_when_offset_exceeds_limit()
    {
        Transaction::factory()->count(3)->create();

        $filters = [];
        $perPage = 2;
        $page = 3; // offset = (3-1)*2 = 4 > total count 3
        $limit = 3;

        $paginator = $this->repository->filter($filters, $perPage, $page, $limit);

        $this->assertEmpty($paginator->items());
        $this->assertEquals(3, $paginator->total());
    }

    public function test_it_can_create_find_update_and_delete_transactions()
    {
        $data = ['transaction_date' => now(), 'amount' => 100];

        // Create
        $transaction = Transaction::factory()->create($data);
        $this->assertDatabaseHas('transactions', ['id' => $transaction->id]);

        // Find
        $found = $this->repository->findById($transaction->id);
        $this->assertEquals($transaction->id, $found->id);

        // Update
        $updated = $this->repository->update($transaction->id, ['amount' => 200]);
        $this->assertNotNull($updated);
        $this->assertDatabaseHas('transactions', ['id' => $transaction->id, 'amount' => 200]);

        // Delete
        $deleted = $this->repository->delete($transaction->id);
        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }
}
