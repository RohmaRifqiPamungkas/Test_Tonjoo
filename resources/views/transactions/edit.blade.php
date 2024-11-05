<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <div class="block mb-8">
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

                <form id="transaction-form" action="{{ route('transactions.update', $transaction->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    <section id="header-container" class="p-4">
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div class="flex flex-col">
                                <label class="block text-gray-700" for="description">Deskripsi</label>
                                <textarea id="description" name="description" class="form-input rounded-md shadow-sm mt-1 block w-full flex-grow"
                                    placeholder="Transaksi Bulan Agustus">{{ old('description', $transaction->description) }}</textarea>
                                @error('description')
                                    <div class="text-red-600 mt-2 text-sm font-semibold">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="flex flex-col space-y-4">
                                <div>
                                    <label class="block text-gray-700" for="code">Kode</label>
                                    <input id="code" name="code" type="text"
                                        class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="LK2536"
                                        value="{{ old('code', $transaction->code) }}">
                                    @error('code')
                                        <div class="text-red-600 mt-2 text-sm font-semibold">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-gray-700" for="rate">Rate Euro</label>
                                    <input id="rate" name="rate_euro" type="number" step="0.01"
                                        class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="15.000"
                                        value="{{ old('rate_euro', $transaction->rate_euro) }}">
                                    @error('rate_euro')
                                        <div class="text-red-600 mt-2 text-sm font-semibold">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-gray-700" for="date_paid">Tanggal Bayar</label>
                                    <input id="date_paid" name="date_paid" type="date"
                                        class="form-input rounded-md shadow-sm mt-1 block w-full"
                                        value="{{ old('date_paid', \Carbon\Carbon::parse($transaction->date_paid)->format('Y-m-d')) }}">
                                    @error('date_paid')
                                        <div class="text-red-600 mt-2 text-sm font-semibold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Detail Transaksi -->
                    <section id="details-container" class="p-4">
                        <div class="mb-4 p-4 border border-gray-300 rounded-lg bg-gray-50 shadow-sm">
                            <h2 class="text-xl font-bold mb-4 text-gray-700">Data Transaksi</h2>
                            <div id="transactionGroups"></div>
                            <button id="addGroupButton"
                                class="bg-green-500 text-white px-4 py-2 mt-4 rounded-md shadow-md hover:bg-green-600 transition-all">
                                Tambah Kelompok
                            </button>
                            <div id="total-amount" class="font-bold mt-4 text-gray-800">Total: 0.00</div>
                        </div>
                    </section>

                    <div class="mt-6 flex justify-end">
                        <button type="reset" class="bg-red-600 text-white px-4 py-2 rounded-md">Batal</button>
                        <button type="submit" class="ml-4 bg-blue-600 text-white px-4 py-2 rounded-md">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let detailIndex = 0;
            const $container = $('#transactionGroups');
            const $totalAmountElement = $('#total-amount');
            const categories = @json($categories);
            const oldDetails = groupDetailsByCategory(@json(old('details', $transaction->details)));

            // Fungsi untuk mengelompokkan oldDetails berdasarkan transaction_category_id
            function groupDetailsByCategory(details) {
                return details.reduce((groups, detail) => {
                    (groups[detail.transaction_category_id] = groups[detail.transaction_category_id] || [])
                    .push(detail);
                    return groups;
                }, {});
            }

            // Debugging: Tampilkan data lama di console
            console.log("Old Details:", oldDetails);

            // Inisialisasi grup transaksi berdasarkan kategori dari data lama
            if (Object.keys(oldDetails).length) {
                Object.values(oldDetails).forEach(details => createTransactionGroup(details));
            } else {
                createTransactionGroup();
            }

            // Fungsi untuk membuat grup transaksi berdasarkan kategori
            function createTransactionGroup(details = []) {
                const $groupDiv = $('<div>', {
                    'class': 'border p-4 mb-4 bg-white shadow-md rounded-md relative'
                });

                const $categorySelect = $('<select>', {
                    'class': 'form-select rounded-md w-full border-gray-300 p-2',
                    'name': `details[${detailIndex}][category]`,
                    'required': true
                }).append('<option value="">Select Category</option>');

                categories.forEach(category => {
                    const isSelected = details.length && details[0].transaction_category_id == category.id;
                    $categorySelect.append(new Option(category.name, category.id, false, isSelected));
                });

                $groupDiv.append(
                    $('<button>', {
                        'class': 'absolute top-2 right-2 text-xl text-red-500',
                        'text': '×'
                    }).click(() => {
                        $groupDiv.remove();
                        updateTotalAmount();
                    }),
                    $('<div>', {
                        'class': 'mb-2'
                    }).append('<label>Category</label>', $categorySelect),
                );

                const $transactionsTable = $('<table>', {
                    'class': 'w-full border-collapse'
                }).html(`
                    <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left">Nama Transaksi</th>
                            <th class="py-3 px-6 text-left">Nominal (IDR)</th>
                            <th class="py-3 px-6 text-left"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                `);

                $groupDiv.append($transactionsTable);
                $container.append($groupDiv); // Tambahkan elemen ke $container

                // Tambah baris transaksi jika ada data lama, atau baris kosong untuk transaksi baru
                detail.transactions.forEach(transaction => addRowToTable($transactionsTable.find('tbody'),
                    detailIndex, transaction));
                if (!detail.transactions.length) addRowToTable($transactionsTable.find('tbody'),
                    detailIndex); // Tambah baris kosong jika tidak ada transaksi

                detailIndex++;
            }

            // Fungsi untuk menambahkan baris transaksi ke tabel
            function addRowToTable($tbody, index, transaction = {}) {
                const rowIndex = $tbody.find('tr').length;
                const $row = $('<tr>').append(
                    $('<td>', {
                        'class': 'border-t p-4'
                    }).append(
                        $('<input>', {
                            type: 'text',
                            name: `details[${index}][transactions][${rowIndex}][name]`,
                            'class': 'form-input rounded-md w-full border-gray-300',
                            placeholder: 'Nama Transaksi',
                            value: transaction.name || ''
                        }),
                        $('<div>', {
                            'class': 'text-red-600 mt-2 text-sm font-semibold',
                            text: validationErrors[`details.${index}.transactions.${rowIndex}.name`] || ''
                        })
                    ),
                    $('<td>', {
                        'class': 'border-t p-2'
                    }).append(
                        $('<input>', {
                            type: 'number',
                            name: `details[${index}][transactions][${rowIndex}][amount]`,
                            'class': 'form-input amount-input rounded-md w-full border-gray-300',
                            placeholder: 'Nominal (IDR)',
                            value: transaction.value_idr || '',
                            'step': '0.01'
                        }).on('input', updateTotalAmount),
                        $('<div>', {
                            'class': 'text-red-600 mt-2 text-sm font-semibold',
                            text: validationErrors[`details.${index}.transactions.${rowIndex}.amount`] || ''
                        })
                    ),
                    $('<td>', {
                        'class': 'border-t p-2'
                    }).append(
                        $('<button>', {
                            'class': 'bg-blue-500 text-white px-2 py-1 mr-1 rounded-md',
                            'text': '+'
                        }).click(e => {
                            e.preventDefault();
                            addRowToTable($tbody, index);
                            updateTotalAmount();
                        }),
                        $('<button>', {
                            'class': 'bg-red-500 text-white px-2 py-1 rounded-md shadow hover:bg-red-600',
                            'text': '−'
                        })
                        .click(e => {
                            e.preventDefault();
                            $row.remove();
                            updateTotalAmount();
                        })
                    )
                );
                $tbody.append($row);
            }

            // Update total jumlah nominal
            function updateTotalAmount() {
                const total = $('.amount-input').toArray().reduce((sum, el) => sum + (parseFloat($(el).val()) || 0),
                    0);
                $('#total-amount').text(`Total: ${total.toFixed(2)}`);
            }

            // Tombol untuk menambah kelompok baru secara manual
            $('#addGroupButton').click(e => {
                e.preventDefault();
                createTransactionGroup();
            });

            // Inisialisasi dari data lama jika ada, atau tambahkan grup kosong
            oldDetails.length ? oldDetails.forEach(createTransactionGroup) : createTransactionGroup();
            updateTotalAmount();
        });
    </script>

    <script>
        const validationErrors = @json($errors->toArray());
        const oldDetails = @json(old('details', []));
    </script>

</x-app-layout>
