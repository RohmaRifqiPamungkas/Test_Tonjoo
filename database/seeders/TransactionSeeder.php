<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\MsCategory;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        // Buat 50 data TransactionHeader
        TransactionHeader::factory(50)->create()->each(function ($transaction) {
            $incomeCategory = MsCategory::where('name', 'Income')->first();
            $expenseCategory = MsCategory::where('name', 'Expense')->first();

            // Tambahkan detail acak untuk setiap transaksi
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'transaction_category_id' => $incomeCategory->id,
                'name' => 'Transaksi Pemasukan ' . $transaction->code,
                'value_idr' => rand(100000, 1000000),
            ]);

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'transaction_category_id' => $expenseCategory->id,
                'name' => 'Transaksi Pengeluaran ' . $transaction->code,
                'value_idr' => rand(100000, 1000000),
            ]);
        });
    }
}