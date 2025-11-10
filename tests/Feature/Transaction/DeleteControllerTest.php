<?php

namespace Tests\Feature\Transaction;

use Tests\TestCase;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_a_transaction_successfully()
    {
        // Create a transaction to delete
        $transaction = Transaction::factory()->create();

        // Make a DELETE request to your controller's route
        $response = $this->deleteJson(route('transactions.delete', ['id' => $transaction->id]));

        // Assertions
        $response->assertStatus(200);
        $response->assertJson([
            'error' => null,
            'errors' => null,
        ]);

        // Ensure transaction no longer exists in the database
        $this->assertDatabaseMissing('transactions', [
            'id' => $transaction->id,
        ]);
    }

    public function test_it_returns_success_even_if_transaction_does_not_exist()
    {
        // Make a DELETE request with a non-existent ID
        $response = $this->deleteJson(route('transactions.delete', ['id' => 9999]));

        // Assertions: controller should still return success
        $response->assertStatus(200);
        $response->assertJson([
            'error' => null,
            'errors' => null,
        ]);
    }
}
