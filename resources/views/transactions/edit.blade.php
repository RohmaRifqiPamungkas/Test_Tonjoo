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

                <form id="transaction-form" action="{{ route('transactions.update', $transaction->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    <section id="header-container" class="p-4">
                        <!-- Header Transaksi -->
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
                                        value="{{ old('rate_euro', $transaction->date_paid) }}">
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let detailIndex = 0;
            const container = document.getElementById('transactionGroups');
            const addGroupButton = document.getElementById('addGroupButton');
            const totalAmountElement = document.getElementById('total-amount');
            
            addGroupButton.addEventListener('click', (event) => {
                event.preventDefault();
                createTransactionGroup();
                updateTotalAmount();
            });

            const transactionDetails = @json($transaction->details);

            const createTransactionGroup = (detail = null) => {
                const groupDiv = document.createElement('div');
                groupDiv.classList.add('border', 'p-4', 'mb-4', 'relative', 'bg-white', 'shadow-md', 'rounded-md');

                const closeButton = document.createElement('button');
                closeButton.innerText = '×';
                closeButton.classList.add('absolute', 'top-2', 'right-2', 'text-xl', 'text-red-500', 'hover:text-red-600');
                closeButton.onclick = () => {
                    groupDiv.remove();
                    updateTotalAmount();
                };
                groupDiv.appendChild(closeButton);

                const categoryDiv = document.createElement('div');
                categoryDiv.classList.add('mb-2');
                const categoryLabel = document.createElement('label');
                categoryLabel.innerText = 'Kategori';
                categoryLabel.classList.add('mr-2');
                const categorySelect = document.createElement('select');
                categorySelect.classList.add('form-select', 'rounded-md', 'shadow-sm', 'p-2', 'border',
                    'border-gray-300', 'w-full');
                categorySelect.name = `details[${detailIndex}][category]`;
                const categories = [{
                    id: 1,
                    name: 'Expense'
                }, {
                    id: 2,
                    name: 'Income'
                }];

                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    if (detail && detail.category_id == category.id) option.selected = true;
                    categorySelect.appendChild(option);
                });

                categoryDiv.appendChild(categoryLabel);
                categoryDiv.appendChild(categorySelect);
                groupDiv.appendChild(categoryDiv);

                const table = document.createElement('table');
                table.classList.add('w-full', 'bg-white', 'border-collapse');
                table.innerHTML = `
                <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">Nama Transaksi</th>
                        <th class="py-3 px-6 text-left">Nominal (IDR)</th>
                        <th class="py-3 px-6 text-left"></th>
                    </tr>
                </thead>
                <tbody></tbody>
            `;
                groupDiv.appendChild(table);
                container.appendChild(groupDiv);

                addRowToTable(table.querySelector('tbody'), detailIndex, detail);
                detailIndex++;
            };

            const addRowToTable = (tbody, index, detail = null) => {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td class="border-t p-4">
                <input type="text" name="details[${index}][name]" class="form-input rounded-md shadow-sm col-span-2 border border-gray-300 w-full" value="${detail ? detail.name : ''}">
            </td>
            <td class="border-t p-2">
                <input type="number" name="details[${index}][amount]" class="form-input amount-input rounded-md shadow-sm col-span-1 border border-gray-300 w-full" value="${detail ? detail.value_idr : ''}">
            </td>
            <td class="border-t p-2">
                <button class="bg-blue-500 text-white px-2 py-1 mr-1 rounded-md shadow hover:bg-blue-600">+</button>
                <button class="bg-red-500 text-white px-2 py-1 rounded-md shadow hover:bg-red-600">−</button>
            </td>
            `;

                const amountInput = row.querySelector('.amount-input');
                const plusButton = row.querySelector('button:nth-child(1)');
                const minusButton = row.querySelector('button:nth-child(2)');

                plusButton.addEventListener('click', (event) => {
                    event.preventDefault();
                    addRowToTable(tbody, index);
                    updateTotalAmount();
                });
                minusButton.addEventListener('click', (event) => {
                    event.preventDefault();
                    row.remove();
                    updateTotalAmount();
                });

                amountInput.addEventListener('input', updateTotalAmount);

                tbody.appendChild(row);
            };

            const updateTotalAmount = () => {
                let total = 0;
                document.querySelectorAll('.amount-input').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                totalAmountElement.textContent = `Total: ${total.toFixed(2)}`;
            };

            transactionDetails.forEach(detail => createTransactionGroup(detail));
            updateTotalAmount();
        });
    </script>

</x-app-layout>
