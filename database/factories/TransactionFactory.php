<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'amount'           => $this->faker->randomFloat(2, 10, 1000),
            'invoice_id'      => $this->faker->uuid(),
            'currency'       => $this->faker->currencyCode(),
            'type'           => $this->faker->randomElement(['credit', 'debit']),
            'reference_code' => $this->faker->bothify('REF-#####'),
            'details'        => $this->faker->sentence(),
        ];
    }
}
