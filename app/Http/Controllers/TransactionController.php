<?php

namespace App\Http\Controllers;

use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\MsCategory;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = TransactionHeader::with('details.category');

        $search = $request->input('search');

        $perPage = $request->input('perPage', 10);

        if ($search) {
            $query->where('description', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")
                ->orWhereHas('details', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $query->orderBy('id', 'asc');
        $transactions = $query->paginate($perPage);

        // Kirimkan data ke view dengan variabel 'transactions' dan 'search'
        return view('transactions.index', compact('transactions', 'search', 'perPage'));
    }

    public function create()
    {
        $categories = MsCategory::all();

        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'description'        => 'required|string|max:255',
            'code'               => 'required|string|max:50',
            'rate_euro'          => 'required|numeric',
            'date_paid'          => 'required|date',
            'details'            => 'required|array',
            'details.*.category' => 'required|integer|exists:ms_categories,id',
            'details.*.name'     => 'required|string|max:255',
            'details.*.amount'   => 'required|numeric',
        ]);
        
        // Membuat transaksi baru di tabel transaction_header
        $transaction = TransactionHeader::create([
            'code'        => $request->input('code'),
            'description' => $request->input('description'),
            'rate_euro'   => $request->input('rate_euro'),
            'date_paid'   => $request->input('date_paid')
        ]);
        
        // Memastikan transaksi baru dibuat sebelum lanjut ke proses detail
        if ($transaction) {
            foreach ($request->details as $detail) {
                $transaction->details()->create([
                    'transaction_id'          => $transaction->id,
                    'transaction_category_id' => $detail['category'],
                    'name'                    => $detail['name'],
                    'value_idr'               => $detail['amount'],
                ]);
            }

            return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
        }

        return redirect()->route('transactions.index')->with('error', 'Failed to create transaction.');
    }

    public function edit(TransactionHeader $transaction)
    {
        // Ambil kategori untuk di dropdown
        $categories = MsCategory::all();

        // Menampilkan form untuk mengedit transaksi
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, TransactionHeader $transaction)
    {
        // Validasi data yang diterima
        $request->validate([
            'code' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rate_euro' => 'required|numeric',
            'date_paid' => 'nullable|date',
            'details' => 'required|array',
            'details.*.category' => 'required|integer|exists:ms_categories,id',
            'details.*.name' => 'required|string',
            'details.*.amount' => 'required|numeric',
        ]);

        // Ambil nilai date_paid, jika tidak ada, gunakan nilai transaksi yang ada
        $datePaid = $request->input('date_paid') ?? $transaction->date_paid;

        // Perbarui informasi transaksi
        $transaction->update([
            'code' => $request->code,
            'description' => $request->description,
            'rate_euro' => $request->rate_euro,
            'date_paid' => $datePaid,
        ]);

        // Hapus detail lama
        $transaction->details()->delete();

        // Tambahkan detail yang baru
        foreach ($request->details as $detail) {
            $transaction->details()->create([
                'transaction_category_id' => $detail['category'],
                'name' => $detail['name'],
                'value_idr' => $detail['amount'],
            ]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(TransactionHeader $transaction)
    {
        // Hapus transaksi beserta detailnya
        $transaction->details()->delete();
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }

    public function recap()
    {
        // Menampilkan rekap transaksi (logikanya perlu diimplementasikan)
        return view('transactions.recap');
    }
}
