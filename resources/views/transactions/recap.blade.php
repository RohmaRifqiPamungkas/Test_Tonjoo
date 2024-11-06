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
                            <a href="{{ route('transactions.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded">List</a>
                            <a href="{{ route('transactions.create') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Form</a>
                            <a href="{{ route('transactions.recap') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Recap</a>
                            <a href="{{ route('transactions.fibonacci.form') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Hitung Fibonacci</a>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-4">
                        <form action="{{ route('transactions.recap') }}" method="GET">
                            <div class="flex space-x-4 mb-4">
                                <a href="{{ route('transactions.index') }}" id="reset-filter-btn"
                                    class="px-4 py-2 bg-blue-200 text-blue-700 rounded hidden">Reset Filter</a>

                                <input type="date" name="start_date" class="form-input rounded-md shadow-sm"
                                    value="{{ request('start_date') }}" oninput="checkInputFields()">
                                <input type="date" name="end_date" class="form-input rounded-md shadow-sm"
                                    value="{{ request('end_date') }}" oninput="checkInputFields()">

                                <select name="transaction_category_id" id="transaction_category_id"
                                    class="form-select rounded-md shadow-sm" onchange="checkInputFields()">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('transaction_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <input type="text" name="search" class="form-input rounded-md shadow-sm"
                                    placeholder="Search" value="{{ request('search') }}" oninput="checkInputFields()">

                                <button type="submit"
                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Search</button>
                            </div>
                        </form>
                    </div>

                    @if ($transactions->isNotEmpty())
                        <div class="bg-white shadow-md rounded overflow-x-auto">
                            <table class="w-full bg-white">
                                <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <tr>
                                        <th class="py-3 px-6 text-left">No</th>
                                        <th class="py-3 px-6 text-left">Tanggal</th>
                                        <th class="py-3 px-6 text-left">Created</th>
                                        <th class="py-3 px-6 text-left">Kategori</th>
                                        <th class="py-3 px-6 text-left">Nominal (IDR)</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach ($transactions as $index => $transaction)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-3 px-6">
                                                {{ $loop->iteration + $transactions->perPage() * ($transactions->currentPage() - 1) }}
                                            </td>
                                            <td class="py-3 px-6">
                                                {{ \Carbon\Carbon::parse($transaction->date_paid)->format('Y-m-d') }}
                                            </td>
                                            <td class="py-3 px-6">{{ \Carbon\Carbon::parse($transaction->created_at) }}
                                            </td>
                                            <td class="py-3 px-6">
                                                <span class="px-3 py-1 text-xs text-white bg-gray-500 rounded-full">
                                                    {{ $transaction->category_name }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-6">
                                                {{ number_format($transaction->total_value_idr, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <p>{{ $transactions->total() }} row(s) selected.</p>
                        </div>

                        <form method="GET" action="{{ route('transactions.recap') }}"
                            class="flex justify-between mt-4">
                            <select name="perPage" class="form-select rounded-md shadow-sm"
                                onchange="this.form.submit()">
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

    <x-footer-component />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        // Fungsi toggle menu
        function toggleMenu(transactionId) {
            $(`#menu-${transactionId}`).toggleClass('hidden');
        }

        // Menutup dropdown saat mengklik di luar dropdown
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.focus\\:outline-none').length) {
                $('.absolute').addClass('hidden');
            }
        });

        // Mengecek input field dan menampilkan tombol reset filter
        function checkInputFields() {
            const startDate = $('input[name="start_date"]').val();
            const endDate = $('input[name="end_date"]').val();
            const categorySelect = $('#transaction_category_id').val();
            const searchInput = $('input[name="search"]').val();

            if (startDate || endDate || categorySelect || searchInput) {
                $('#reset-filter-btn').removeClass('hidden');
            } else {
                $('#reset-filter-btn').addClass('hidden');
            }
        }

        // Inisialisasi DataTable
        $(document).ready(function() {
            $('table').DataTable({
                "searching": false,
                "paging": false,
                "ordering": true,
                "info": false
            });
        });
    </script>

</x-app-layout>
