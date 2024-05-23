<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreTransaction()
    {
        $transactionData = [
            'amount' => 100.00,
            'category' => 'Test Category',
            'transfer_type' => 'Test Type',
            'date' => '2024-05-23',
            'details' => [
                [
                    'item_name' => 'Item 1',
                    'unit_price' => 50.00,
                    'quantity' => 1
                ],
                [
                    'item_name' => 'Item 2',
                    'unit_price' => 25.00,
                    'quantity' => 2
                ]
            ]
        ];

        $response = $this->post('/transactions', $transactionData);

        $response->assertRedirect('/transactions');
        $this->assertDatabaseHas('transactions', ['amount' => 100.00, 'category' => 'Test Category']);
        $this->assertDatabaseHas('transaction_details', ['item_name' => 'Item 1', 'unit_price' => 50.00, 'quantity' => 1]);
        $this->assertDatabaseHas('transaction_details', ['item_name' => 'Item 2', 'unit_price' => 25.00, 'quantity' => 2]);
    }
}
