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
                        <!-- Menampilkan pesan error -->
                        @if ($errors->any())
                            <div class="p-3 rounded bg-red-500 text-white mb-4">
                                <h4 class="font-bold">There were some errors:</h4>
                                <ul class="list-disc ml-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Menampilkan pesan sukses -->
                        @if (session('success'))
                            <div class="p-3 rounded bg-green-500 text-green-100 mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="flex space-x-4">
                            <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">List</a>
                            <a href="{{ route('transactions.create') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Form</a>
                            <a href="{{ route('transactions.recap') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Recap</a>
                            <a href="{{ route('transactions.fibonacci.form') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Hitung Fibonacci</a>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-4">
                        <form action="{{ route('transactions.index') }}" method="GET">
                            <div class="flex space-x-4 mb-4">
                                <a href="{{ route('transactions.index') }}" id="reset-filter-btn"
                                    class="px-4 py-2 bg-blue-200 text-blue-700 rounded hidden">Reset Filter</a>

                                <input type="date" name="start_date" class="form-input rounded-md shadow-sm" value="{{ request('start_date') }}" oninput="checkInputFields()">
                                <input type="date" name="end_date" class="form-input rounded-md shadow-sm" value="{{ request('end_date') }}" oninput="checkInputFields()">
                                <select name="transaction_category_id" id="transaction_category_id" class="form-select rounded-md shadow-sm" onchange="checkInputFields()">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('transaction_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <input type="text" name="search" class="form-input rounded-md shadow-sm" placeholder="Search" value="{{ request('search') }}" oninput="checkInputFields()">

                                <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Search</button>
                            </div>
                        </form>
                    </div>

                    @if ($transactions->isNotEmpty())
                        <div class="bg-white shadow-md rounded overflow-x-auto">
                            <table class="w-full bg-white">
                                <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <tr>
                                        <th class="py-3 px-6 text-left">No</th>
                                        <th class="py-3 px-6 text-left">Description</th>
                                        <th class="py-3 px-6 text-left">Code</th>
                                        <th class="py-3 px-6 text-left">Rate Eur</th>
                                        <th class="py-3 px-6 text-left">Created</th>
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
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                {{ $loop->iteration + $transactions->perPage() * ($transactions->currentPage() - 1) }}
                                            </td>
                                            <td class="py-3 px-6 text-left">{{ $transaction->description }}</td>
                                            <td class="py-3 px-6 text-left">{{ $transaction->code }}</td>
                                            <td class="py-3 px-6 text-left">{{ $transaction->rate_euro }}</td>
                                            <td class="py-3 px-6 text-left">{{ $transaction->created_at }}</td>
                                            <td class="py-3 px-6 text-left">{{ \Carbon\Carbon::parse($transaction->date_paid)->format('d M Y') }}</td>
                                            <td class="py-3 px-6">
                                                <span class="px-3 py-1 text-xs text-white bg-gray-500 rounded-full">{{ $transaction->category_name }}</span>
                                            </td>
                                            <td class="py-3 px-6">{{ $transaction->detail_name }}</td>
                                            <td class="py-3 px-6">Rp{{ number_format($transaction->detail_value_idr, 2) }}</td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="relative inline-block text-left">
                                                    <button onclick="toggleMenu({{ $transaction->id }})" class="focus:outline-none">
                                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 2c.672 0 1.24.534 1.24 1.192S12.672 4.384 12 4.384s-1.24-.534-1.24-1.192S11.328 2 12 2zm0 6c.672 0 1.24.534 1.24 1.192S12.672 9.384 12 9.384S10.76 8.85 10.76 8.192S11.328 8 12 8zm0 6c.672 0 1.24.534 1.24 1.192S12.672 15.384 12 15.384S10.76 14.85 10.76 14.192S11.328 14 12 14z"></path>
                                                        </svg>
                                                    </button>
                                                    <div id="menu-{{ $transaction->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded shadow-md">
                                                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit</a>
                                                        <a href="{{ route('transactions.show', $transaction->id) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">View</a>
                                                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100" onclick="return confirm('Are you sure?')">Delete</button>
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

                        <form method="GET" action="{{ route('transactions.index') }}" class="flex justify-between mt-4">
                            <select name="perPage" class="form-select rounded-md shadow-sm" onchange="this.form.submit()">
                                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            {{ $transactions->links() }}
                        </form>
                    @else
                        <p class="text-gray-500">No transactions found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleMenu(transactionId) {
            const menu = document.getElementById(`menu-${transactionId}`);
            menu.classList.toggle('hidden');
        }

        window.onclick = function(event) {
            if (!event.target.matches('.focus:outline-none')) {
                const dropdowns = document.querySelectorAll('.absolute');
                dropdowns.forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            }
        }

        function checkInputFields() {
            const startDate = document.querySelector('input[name="start_date"]').value;
            const endDate = document.querySelector('input[name="end_date"]').value;
            const categorySelect = document.getElementById('transaction_category_id').value;
            const searchInput = document.querySelector('input[name="search"]').value;

            const resetButton = document.getElementById('reset-filter-btn');
            if (startDate || endDate || categorySelect || searchInput) {
                resetButton.classList.remove('hidden');
            } else {
                resetButton.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
