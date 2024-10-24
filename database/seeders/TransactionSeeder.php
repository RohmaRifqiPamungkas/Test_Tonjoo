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
            // Pilih salah satu kategori secara acak (Income atau Expense)
            $randomCategory = MsCategory::inRandomOrder()->first();

            // Tambahkan detail acak untuk setiap transaksi dengan satu kategori saja
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'transaction_category_id' => $randomCategory->id,
                'name' => 'Transaksi ' . $randomCategory->name . ' ' . $transaction->code,
                'value_idr' => rand(100000, 1000000),
            ]);
        });
    }
}