<?php

namespace App\Http\Controllers;

use App\Models\MsCategory;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $categories = MsCategory::all();

        $perPage = $request->input('perPage', 10);

        // Mengambil semua data dari transaction_headers dan transaction_details tanpa agregasi
        $query = TransactionHeader::join('transaction_details', 'transaction_headers.id', '=', 'transaction_details.transaction_id')
            ->join('ms_categories', 'transaction_details.transaction_category_id', '=', 'ms_categories.id')
            ->select(
                'transaction_headers.id',
                'transaction_headers.description',
                'transaction_headers.code',
                'transaction_headers.rate_euro',
                'transaction_headers.date_paid',
                'transaction_details.id as detail_id',
                'transaction_details.name as detail_name',
                'transaction_details.value_idr as detail_value_idr',
                'ms_categories.name as category_name'
            )
            ->orderBy('transaction_headers.date_paid', 'asc');

        // Filter berdasarkan kategori
        $transactionCategoryId = $request->input('transaction_category_id');
        if ($transactionCategoryId) {
            $query->where('transaction_details.transaction_category_id', $transactionCategoryId);
        }

        // Filter dan validasi berdasarkan tanggal
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate && $endDate) {
            if ($startDate > $endDate) {
                return redirect()->route('transactions.index')
                ->withErrors(['end_date' => 'The end date cannot be earlier than the start date.'])
                ->withInput();
            }

            $query->whereBetween('transaction_headers.date_paid', [$startDate, $endDate]);
        }

        // Filter berdasarkan deskripsi atau nama transaksi
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_headers.description', 'like', '%' . $search . '%')
                    ->orWhere('transaction_headers.code', 'like', '%' . $search . '%')
                    ->orWhere('transaction_details.name', 'like', '%' . $search . '%');
            });
        }

        // Mengambil data dengan paginasi
        $transactions = $query->paginate($perPage);

        return view('transactions.index', compact('transactions', 'categories', 'transactionCategoryId', 'startDate', 'endDate', 'search'));
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
            'description'              => 'required|string|max:255',
            'code'                     => 'required|string|max:50',
            'rate_euro'                => 'required|numeric',
            'date_paid'                => 'required|date',
            'details'                  => 'required|array',
            'details.*.category'       => 'required|integer',
            'details.*.transactions'   => 'required|array',
            'details.*.transactions.*.name'   => 'required|string|max:255',
            'details.*.transactions.*.amount' => 'required|numeric',
        ]);

        // Grupkan transaksi berdasarkan kategori
        $groupedDetails = [];
        foreach ($request->input('details') as $detail) {
            $category = $detail['category'];

            if (!isset($groupedDetails[$category])) {
                $groupedDetails[$category] = [
                    'category' => $category,
                    'transactions' => []
                ];
            }

            // Tambahkan setiap transaksi ke kategori yang sesuai
            foreach ($detail['transactions'] as $transaction) {
                $groupedDetails[$category]['transactions'][] = [
                    'name' => $transaction['name'],
                    'amount' => $transaction['amount']
                ];
            }
        }

        // Buat transaksi header
        $transaction = TransactionHeader::create([
            'code'        => $request->input('code'),
            'description' => $request->input('description'),
            'rate_euro'   => $request->input('rate_euro'),
            'date_paid'   => $request->input('date_paid'),
        ]);

        // Simpan setiap detail transaksi dengan struktur yang dikelompokkan
        if ($transaction) {
            foreach ($groupedDetails as $detailGroup) {
                foreach ($detailGroup['transactions'] as $transactionDetail) {
                    $transaction->details()->create([
                        'transaction_category_id' => $detailGroup['category'],
                        'name'                    => $transactionDetail['name'],
                        'value_idr'               => $transactionDetail['amount'],
                    ]);
                }
            }
            return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
        }

        return redirect()->route('transactions.index')->with('error', 'Failed to create transaction.');
    }

    public function show($id)
    {
        $transaction = TransactionHeader::with('details.category')->findOrFail($id);
        $categories = MsCategory::all();

        return view('transactions.show', compact('transaction', 'categories'));
    }

    public function edit(TransactionHeader $transaction)
    {
        $categories = MsCategory::all();
        $transaction->load('details'); // Pastikan eager loading pada relasi `details`

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, TransactionHeader $transaction)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rate_euro' => 'required|numeric',
            'date_paid' => 'nullable|date',
            'details' => 'required|array',
            'details.*.category' => 'required|integer|exists:ms_categories,id',
            'details.*.transactions.*.name' => 'required|string',
            'details.*.transactions.*.amount' => 'required|numeric',
        ]);

        // Update informasi utama transaksi
        $transaction->update([
            'code' => $request->code,
            'description' => $request->description,
            'rate_euro' => $request->rate_euro,
            'date_paid' => $request->input('date_paid') ?? $transaction->date_paid,
        ]);

        // Hapus detail transaksi yang lama
        $transaction->details()->delete();

        // Tambahkan detail transaksi baru
        foreach ($request->details as $detail) {
            foreach ($detail['transactions'] as $trans) {
                $transaction->details()->create([
                    'transaction_category_id' => $detail['category'],
                    'name' => $trans['name'],
                    'value_idr' => $trans['amount'],
                ]);
            }
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(TransactionHeader $transaction)
    {
        $transaction->details()->delete();
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }

    public function recap(Request $request)
    {
        $categories = MsCategory::all();

        $query = TransactionHeader::with('details.category');

        $perPage = $request->input('perPage', 10);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $transactionCategoryId = $request->input('transaction_category_id');
        $search = $request->input('search');

        // Query untuk mengambil data transaksi beserta kategori dan total nilai
        $query = TransactionHeader::query()
            ->join('transaction_details', 'transaction_headers.id', '=', 'transaction_details.transaction_id')
            ->join('ms_categories', 'transaction_details.transaction_category_id', '=', 'ms_categories.id')
            ->select(
                'transaction_headers.date_paid',
                'ms_categories.name as category_name',
                DB::raw('SUM(transaction_details.value_idr) as total_value_idr'),
            )
            ->groupBy('transaction_headers.date_paid', 'ms_categories.name')
            ->orderBy('transaction_headers.date_paid', 'asc');

        // Filter kategori
        if ($transactionCategoryId) {
            $query->where('transaction_details.transaction_category_id', $transactionCategoryId);
        }

        // Filter berdasarkan tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('transaction_headers.date_paid', [$startDate, $endDate]);
        }

        // Filter berdasarkan nama transaksi
        if ($search) {
            $query->where('transaction_details.name', 'like', '%' . $search . '%');
        }

        $transactions = $query->paginate($perPage);

        return view('transactions.recap', compact('transactions', 'startDate', 'endDate', 'transactionCategoryId', 'categories', 'search'));
    }
}