<?php

namespace Tests\Feature\Transaction;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_transaction_successfully()
    {
        // Prepare fake data for the request
        $data = [
            'amount' => 150.50,
            'invoice_id' => 12345,
            'currency' => 'USD',
            'transaction_date' => now()->toDateString(),
            'type' => 'credit',
            'reference_code' => 'REF123456',
            'details' => 'Test details',
        ];

        // Make a POST request to your controller's route
        $response = $this->postJson(route('transactions.create'), $data);

        // Assertions
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'errors',
            'error',
            'extra',
            'data' => [
                'id',
                'amount',
                'invoice_id',
                'currency',
                'transaction_date',
                'type',
                'reference_code',
                'details',
                'created_at',
                'updated_at',
            ],
        ]);

        // Ensure transaction exists in the database
        $this->assertDatabaseHas('transactions', [
            'invoice_id' => $data['invoice_id'],
            'amount' => $data['amount'],
        ]);
    }
}
