<?php

namespace Tests\Feature\Transaction;

use Tests\TestCase;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_transaction_successfully()
    {
        // Create a transaction to update
        $transaction = Transaction::factory()->create([
            'amount' => 100,
        ]);

        // Prepare update data
        $data = [
            'amount' => 200,
            'invoice_id' => $transaction->invoice_id,
            'currency' => 'USD',
            'transaction_date' => now()->toDateString(),
            'type' => 'credit',
            'reference_code' => 'REF999',
            'details' => 'Updated details',
        ];

        // Make a PUT request to your update route
        $response = $this->putJson(route('transactions.update', ['id' => $transaction->id]), $data);

        // Assertions
        $response->assertStatus(200);
        $response->assertJson([
            'error' => null,
            'errors' => null,
        ]);

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'amount' => 200,
        ]);
    }

    public function test_it_returns_success_even_if_transaction_does_not_exist()
    {
        $data = [
            'amount' => 200,
            'invoice_id' => 123,
            'currency' => 'USD',
            'transaction_date' => now()->toDateString(),
            'type' => 'credit',
            'reference_code' => 'REF000',
            'details' => 'N/A',
        ];

        // Make a PUT request with a non-existent ID
        $response = $this->putJson(route('transactions.update', ['id' => 9999]), $data);

        // Assertions: controller still returns success (matches repository behavior)
        $response->assertStatus(200);
        $response->assertJson([
            'error' => null,
            'errors' => null,
        ]);
    }
}
