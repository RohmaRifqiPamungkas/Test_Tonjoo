<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <form id="transaction-form" action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Menambahkan method PUT untuk update data -->

                    <section id="header-container" class="p-4">
                        <!-- Header Transaksi -->
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700" for="description">Deskripsi</label>
                                <textarea id="description" name="description" class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    placeholder="Transaksi Bulan Agustus">{{ old('description', $transaction->description) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700" for="code">Kode</label>
                                <input id="code" name="code" type="text"
                                    class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="123456"
                                    value="{{ old('code', $transaction->code) }}">
                            </div>
                            <div>
                                <label class="block text-gray-700" for="rate">Rate Euro</label>
                                <input id="rate" name="rate_euro" type="number" step="0.01"
                                    class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="15.000"
                                    value="{{ old('rate_euro', $transaction->rate_euro) }}">
                            </div>
                            <div>
                                <label class="block text-gray-700" for="date_paid">Tanggal Bayar</label>
                                <input id="date_paid" name="date_paid" type="date"
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    value="{{ $transaction->date_paid }}">
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
            let detailIndex = 0; // Indeks untuk detail transaksi
            const container = document.getElementById('transactionGroups');
            const addGroupButton = document.getElementById('addGroupButton');

            // Event listener untuk tombol tambah kelompok
            addGroupButton.addEventListener('click', (event) => {
                event.preventDefault();
                createTransactionGroup();
            });

            // Fungsi untuk membuat kelompok transaksi baru
            const createTransactionGroup = () => {
                const groupDiv = document.createElement('div');
                groupDiv.classList.add('border', 'p-4', 'mb-4', 'relative', 'bg-white', 'shadow-md', 'rounded-md');

                // Tombol untuk menghapus kelompok
                const closeButton = document.createElement('button');
                closeButton.innerText = '×';
                closeButton.classList.add('absolute', 'top-2', 'right-2', 'text-xl', 'text-red-500', 'hover:text-red-600');
                closeButton.onclick = () => groupDiv.remove(); // Menghapus kelompok saat diklik
                groupDiv.appendChild(closeButton);

                // Dropdown kategori
                const categoryDiv = document.createElement('div');
                categoryDiv.classList.add('mb-2');
                const categoryLabel = document.createElement('label');
                categoryLabel.innerText = 'Kategori';
                categoryLabel.classList.add('mr-2');
                const categorySelect = document.createElement('select');
                categorySelect.classList.add('form-select', 'rounded-md', 'shadow-sm', 'p-2', 'border', 'border-gray-300', 'w-full');
                categorySelect.name = `details[${detailIndex}][category]`;

                // Daftar kategori, bisa disesuaikan dengan data dari backend
                const categories = [
                    { id: 1, name: 'Income' },
                    { id: 2, name: 'Expense' },
                ];

                // Menambahkan opsi kategori ke dropdown
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });

                categoryDiv.appendChild(categoryLabel);
                categoryDiv.appendChild(categorySelect);
                groupDiv.appendChild(categoryDiv);

                // Membuat tabel untuk detail transaksi
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

                // Menambahkan baris ke tabel
                addRowToTable(table.querySelector('tbody'), detailIndex);
                detailIndex++; // Increment indeks untuk detail selanjutnya
            };

            // Fungsi untuk menambahkan baris ke tabel
            const addRowToTable = (tbody, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="border-t p-4">
                        <input type="text" name="details[${index}][name]" class="form-input rounded-md shadow-sm col-span-2 border border-gray-300 w-full" placeholder="Contoh: Mobil Agustus">
                    </td>
                    <td class="border-t p-2">
                        <input type="number" name="details[${index}][amount]" class="form-input rounded-md shadow-sm col-span-1 border border-gray-300 w-full" placeholder="800.000">
                    </td>
                    <td class="border-t p-2">
                        <button class="bg-blue-500 text-white px-2 py-1 mr-1 rounded-md shadow hover:bg-blue-600">+</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded-md shadow hover:bg-red-600">−</button>
                    </td>
                `;

                const plusButton = row.querySelector('button:nth-child(1)');
                const minusButton = row.querySelector('button:nth-child(2)');

                // Event listener untuk menambah baris
                plusButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Mencegah pengiriman form
                    addRowToTable(tbody, index);
                });

                // Event listener untuk menghapus baris
                minusButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Mencegah pengiriman form
                    row.remove();
                });

                tbody.appendChild(row);
            };
        });
    </script>
</x-app-layout>
