<?php

namespace Tests\Feature;

use App\Models\TransactionHeader; // Ganti dengan model yang sesuai
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Models\MsCategory;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate'); // Jalankan migrasi sebelum setiap pengujian
    }

    #[Test]
    public function it_can_show_the_transactions_page()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        // Seed some transaction data
        TransactionHeader::factory()->count(5)->create(); // Ganti dengan model yang sesuai

        $response = $this->actingAs($user)->get(route('transactions.index'));

        $response->assertStatus(200);
        $response->assertSee('Transactions');
    }

    #[Test]
    public function it_can_show_the_transaction_create_page()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('transactions.create'));

        $response->assertStatus(200);
        $response->assertSee('Create Transaction');
    }

    #[Test]
    public function it_can_create_a_transaction()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        // Siapkan kategori untuk digunakan
        $category = MsCategory::factory()->create(['name' => 'Category 1']); // Membuat kategori

        $transactionData = [
            'code' => 'TR123456',
            'description' => 'Sample transaction',
            'rate_euro' => 100.00,
            'date_paid' => '2023-10-10',
            'details' => [
                ['category' => $category->id, 'name' => 'Detail 1', 'amount' => 50.00],
                ['category' => $category->id, 'name' => 'Detail 2', 'amount' => 50.00],
            ]
        ];

        $response = $this->actingAs($user)->post(route('transactions.store'), $transactionData);

        $response->assertStatus(302); // Status redirect
        $response->assertRedirect(route('transactions.index'));

        // Memastikan data disimpan di database
        $this->assertDatabaseHas('transaction_headers', [
            'code' => 'TR123456',
            'description' => 'Sample transaction',
            'rate_euro' => 100.00,
            'date_paid' => '2023-10-10',
        ]);

        $this->assertDatabaseHas('transaction_details', [
            'name' => 'Detail 1',
            'value_idr' => 50.00,
            'transaction_category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('transaction_details', [
            'name' => 'Detail 2',
            'value_idr' => 50.00,
            'transaction_category_id' => $category->id,
        ]);
    }

    #[Test]
    public function it_can_delete_a_transaction()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $transaction = TransactionHeader::factory()->create(); // Membuat transaksi untuk diuji

        $response = $this->actingAs($user)->delete(route('transactions.destroy', $transaction->id));

        $response->assertStatus(302); // Status redirect setelah penghapusan
        $response->assertRedirect(route('transactions.index'));

        // Memastikan data sudah dihapus dari database
        $this->assertDatabaseMissing('transaction_headers', [
            'id' => $transaction->id, // Menggunakan ID untuk memverifikasi penghapusan
        ]);
    }
}
