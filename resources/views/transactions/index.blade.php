<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="block mb-8">
                        <div class="flex space-x-4">
                            <a href="{{ route('transactions.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded">List</a>
                            <a href="{{ route('transactions.create') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Form</a>
                            <a href="{{ route('transactions.recap') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Recap</a>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-4">
                        <form action="{{ route('transactions.index') }}" method="GET" class="flex gap-4 mb-4">
                            <input type="search" name="search" id="search"
                                class="form-input rounded-md shadow-sm w-full" value="{{ request('search') }}"
                                placeholder="Search description or code...">
                            <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Search</button>
                            <input type="date" class="form-input rounded-md shadow-sm w-full">
                            <input type="date" class="form-input rounded-md shadow-sm w-full">
                            <select name="transaction_type" id="transaction_type" class="form-select rounded-md shadow-sm">
                                <option value="">Select Type</option>
                                <option value="income" {{ request('transaction_type') === 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ request('transaction_type') === 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                        </form>
                    </div>

                    <div class="bg-white shadow-md rounded overflow-x-auto">
                        <table class="w-full bg-white">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="py-3 px-6 text-left">No</th>
                                    <th class="py-3 px-6 text-left">Description</th>
                                    <th class="py-3 px-6 text-left">Code</th>
                                    <th class="py-3 px-6 text-left">Rate Eur</th>
                                    <th class="py-3 px-6 text-left">Date Paid</th>
                                    <th class="py-3 px-6 text-left">Category</th>
                                    <th class="py-3 px-6 text-left">Name Transaction</th>
                                    <th class="py-3 px-6 text-left">Nominal</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($transactions as $index => $transaction)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <!-- Menampilkan nomor urut yang melanjutkan dari halaman sebelumnya -->
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            {{ $loop->iteration + $transactions->perPage() * ($transactions->currentPage() - 1) }}
                                        </td>
                                        <td class="py-3 px-6 text-left">{{ $transaction->description }}</td>
                                        <td class="py-3 px-6 text-left">{{ $transaction->code }}</td>
                                        <td class="py-3 px-6 text-left">{{ $transaction->rate_euro }}</td>
                                        <td class="py-3 px-6 text-left">
                                            {{ \Carbon\Carbon::parse($transaction->date_paid)->format('d M Y') }}
                                        </td>

                                        <!-- Menampilkan Kategori dari Detail -->
                                        <td class="py-3 px-6">
                                            @if ($transaction->details->isNotEmpty())
                                                @foreach ($transaction->details as $detail)
                                                    <span class="px-3 py-1 text-xs text-white bg-gray-500 rounded-full">
                                                        {{ $detail->category ? $detail->category->name : 'No Category' }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="px-3 py-1 text-xs text-white bg-gray-500 rounded-full">No Category</span>
                                            @endif
                                        </td>

                                        <!-- Nama Transaksi dan Nominal -->
                                        @if ($transaction->details->isNotEmpty())
                                            <td class="py-3 px-6">{{ $transaction->details[0]->name }}</td>
                                            <td class="py-3 px-6">Rp{{ number_format($transaction->details[0]->value_idr, 2) }}</td>
                                        @else
                                            <td class="py-3 px-6">-</td>
                                            <td class="py-3 px-6">-</td>
                                        @endif

                                        <!-- Actions -->
                                        <td class="py-3 px-6 text-center">
                                            <div class="relative inline-block text-left">
                                                <button onclick="toggleMenu({{ $transaction->id }})"
                                                    class="focus:outline-none">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12 2c.672 0 1.24.534 1.24 1.192S12.672 4.384 12 4.384s-1.24-.534-1.24-1.192S11.328 2 12 2zm0 6c.672 0 1.24.534 1.24 1.192S12.672 9.384 12 9.384S10.76 8.85 10.76 8.192S11.328 8 12 8zm0 6c.672 0 1.24.534 1.24 1.192S12.672 15.384 12 15.384S10.76 14.85 10.76 14.192S11.328 14 12 14z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <div id="menu-{{ $transaction->id }}"
                                                    class="hidden absolute right-0 mt-2 w-48 bg-white border rounded shadow-md">
                                                    <a href="{{ route('transactions.edit', $transaction->id) }}"
                                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit</a>
                                                    <form
                                                        action="{{ route('transactions.destroy', $transaction->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100"
                                                            onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <p>{{ $transactions->total() }} row(s) selected.</p>
                    </div>

                    {{-- Form untuk pemilihan jumlah data per halaman --}}
                    <form method="GET" action="{{ route('transactions.index') }}" class="flex justify-between mt-4">
                        {{-- Dropdown untuk memilih jumlah data per halaman --}}
                        <select name="perPage" class="form-select rounded-md shadow-sm" onchange="this.form.submit()">
                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                        </select>

                        {{-- Navigasi halaman --}}
                        <div class="flex items-center">
                            {{-- Tombol Previous --}}
                            @if ($transactions->onFirstPage())
                                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded" disabled>Previous</button>
                            @else
                                <a href="{{ $transactions->appends(['perPage' => request('perPage'), 'search' => request('search')])->previousPageUrl() }}"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Previous</a>
                            @endif

                            {{-- Tombol Next --}}
                            @if ($transactions->hasMorePages())
                                <a href="{{ $transactions->appends(['perPage' => request('perPage'), 'search' => request('search')])->nextPageUrl() }}"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded ml-2">Next</a>
                            @else
                                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded ml-2" disabled>Next</button>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMenu(id) {
            const menu = document.getElementById('menu-' + id);
            menu.classList.toggle('hidden');
        }
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.relative')) {
                document.querySelectorAll('.relative div').forEach(function(menu) {
                    menu.classList.add('hidden');
                });
            }
        });
    </script>
</x-app-layout>
