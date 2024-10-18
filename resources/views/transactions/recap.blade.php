<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recap Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('transactions.recap') }}" method="GET">
                        <div class="flex space-x-4 mb-4">
                            <a href="{{ route('transactions.recap') }}"
                                class="px-4 py-2 bg-blue-200 text-blue-700 rounded">Reset Filter</a>

                            <input type="date" name="start_date" class="form-input rounded-md shadow-sm"
                                value="{{ request('start_date') }}">
                            <input type="date" name="end_date" class="form-input rounded-md shadow-sm"
                                value="{{ request('end_date') }}">

                            <select name="transaction_category_id" id="transaction_category_id"
                                class="form-select rounded-md shadow-sm">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('transaction_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="text" name="search" class="form-input rounded-md shadow-sm"
                                placeholder="Search" value="{{ request('search') }}">

                            <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Search</button>
                        </div>
                    </form>


                    @if (isset($transactions))
                        <div class="bg-white shadow-md rounded overflow-x-auto">
                            <table class="w-full bg-white">
                                <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <tr>
                                        <th class="py-3 px-6 text-left">No</th>
                                        <th class="py-3 px-6 text-left">Tanggal</th>
                                        <th class="py-3 px-6 text-left">Kategori</th>
                                        <th class="py-3 px-6 text-left">Nominal (IDR)</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach ($transactions as $index => $transaction)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-3 px-6">{{ $loop->iteration }}</td>
                                            <td class="py-3 px-6">
                                                {{ \Carbon\Carbon::parse($transaction->date_paid)->format('Y-m-d H:i:s') }}
                                            </td>
                                            <td class="py-3 px-6">
                                                @if ($transaction->details->isNotEmpty())
                                                    @foreach ($transaction->details as $detail)
                                                        <span
                                                            class="px-3 py-1 text-xs text-white bg-gray-500 rounded-full">
                                                            {{ $detail->category ? $detail->category->name : 'No Category' }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    <span
                                                        class="px-3 py-1 text-xs text-white bg-gray-500 rounded-full">No
                                                        Category</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6">
                                                {{ number_format($transaction->details->sum('value_idr'), 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
