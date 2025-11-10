<?php

namespace Tests\Feature\Transaction;

use Tests\TestCase;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_fetches_transactions_with_pagination()
    {
        // Seed some transactions
        Transaction::factory()->count(10)->create();

        // Make a GET request to your fetch route
        $response = $this->getJson(route('transactions.fetch', [
            'page' => 1,
            'perPage' => 5,
            'limit' => 8,
        ]));

        // Assertions
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'error',
            'errors',
            'data',
        ]);

        $this->assertCount(5, $response->json('data'));
        $this->assertEquals(1, $response->json('extra.meta.current_page'));
    }

    public function test_it_applies_date_filters_correctly()
    {
        // Create transactions on different dates
        Transaction::factory()->create(['transaction_date' => '2025-01-01']);
        Transaction::factory()->create(['transaction_date' => '2025-01-15']);
        Transaction::factory()->create(['transaction_date' => '2025-02-01']);

        // Fetch with filter: Jan 2025 only
        $response = $this->getJson(route('transactions.fetch', [
            'filters' => [
                'date_from' => '2025-01-01',
                'date_to' => '2025-01-31',
            ],
            'page' => 1,
            'perPage' => 10,
            'limit' => 10,
        ]));

        $response->assertStatus(200);
        $data = $response->json('data');

        $this->assertCount(2, $data); // only two transactions in Jan
        foreach ($data as $transaction) {
            $this->assertStringStartsWith('2025-01', $transaction['transaction_date']);
        }
    }
}
