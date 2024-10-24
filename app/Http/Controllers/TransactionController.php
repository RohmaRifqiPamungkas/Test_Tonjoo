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
        $categories = MsCategory::all();

        $query = TransactionHeader::with('details.category');

        $search = $request->input('search');
        $transactionCategoryId = $request->input('transaction_category_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $perPage = $request->input('perPage', 10);

        if ($startDate && $endDate && $startDate > $endDate) {
            return redirect()->route('transactions.index')
                             ->withErrors(['end_date' => 'The end date cannot be earlier than the start date.'])
                             ->withInput(); 
        }

        $query = TransactionHeader::with('details.category');
        
        if ($search) {
            $query->where('description', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")
                ->orWhereHas('details', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        if ($transactionCategoryId) {
            $query->whereHas('details.category', function ($q) use ($transactionCategoryId) {
                $q->where('id', $transactionCategoryId);
            });
        }

        if ($startDate) {
            $query->where('date_paid', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('date_paid', '<=', $endDate);
        }

        $query->orderBy('id', 'asc');
        $transactions = $query->paginate($perPage);

        return view('transactions.index', compact('transactions', 'search', 'transactionCategoryId', 'startDate', 'endDate', 'perPage', 'categories'));
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

        $transaction = TransactionHeader::create([
            'code'        => $request->input('code'),
            'description' => $request->input('description'),
            'rate_euro'   => $request->input('rate_euro'),
            'date_paid'   => $request->input('date_paid')
        ]);

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

    public function show($id)
    {
        $transaction = TransactionHeader::with('details.category')->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }
    
    public function edit(TransactionHeader $transaction)
    {
        $categories = MsCategory::all();

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
            'details.*.name' => 'required|string',
            'details.*.amount' => 'required|numeric',
        ]);

        $datePaid = $request->input('date_paid') ?? $transaction->date_paid;

        $transaction->update([
            'code' => $request->code,
            'description' => $request->description,
            'rate_euro' => $request->rate_euro,
            'date_paid' => $datePaid,
        ]);

        $transaction->details()->delete();

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
        $transaction->details()->delete();
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }

    public function recap(Request $request)
    {
        $categories = MsCategory::all();
        $query = TransactionHeader::with('details.category');
            
        $startDate = $request->input('start_date');
        $transactionCategoryId = $request->input('transaction_category_id');
        $endDate = $request->input('end_date');
        $category = $request->input('category', 'all');
        $search = $request->input('search');

        $query = TransactionHeader::with('details.category')->orderBy('date_paid', 'asc');

        if ($startDate && $endDate) {
            $query->whereBetween('date_paid', [$startDate, $endDate]);
        }

        if ($transactionCategoryId) {
            $query->whereHas('details.category', function ($q) use ($transactionCategoryId) {
                $q->where('id', $transactionCategoryId);
            });
        }

        if ($search) {
            $query->whereHas('details', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $transactions = $query->get();

        $totalValueIdr = $transactions->reduce(function ($carry, $transaction) {
            return $carry + $transaction->details->sum('value_idr');
        }, 0);
        
        $totalRateEuro = $transactions->sum('rate_euro');

        return view('transactions.recap', compact('transactions', 'startDate', 'endDate', 'category', 'search', 'transactionCategoryId', 'categories', 'totalValueIdr', 'totalRateEuro'));
    }
}