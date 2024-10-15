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

                    <!-- Header Transaksi -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700" for="description">Deskripsi</label>
                            <textarea id="description" name="description" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Transaksi Bulan Agustus">{{ old('description', $transaction->description) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700" for="code">Kode</label>
                            <input id="code" name="code" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="123456" value="{{ old('code', $transaction->code) }}">
                        </div>
                        <div>
                            <label class="block text-gray-700" for="rate">Rate Euro</label>
                            <input id="rate" name="rate_euro" type="number" step="0.01" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="15.000" value="{{ old('rate_euro', $transaction->rate_euro) }}">
                        </div>
                        <div>
                            <label class="block text-gray-700" for="date_paid">Tanggal Bayar</label>
                            <input id="date_paid" name="date_paid" type="date" class="form-input rounded-md shadow-sm mt-1 block w-full" value="{{ $transaction->date_paid }}">
                        </div>
                    </div>

                    <!-- Detail Transaksi -->
                    <div id="details-container">
                        @foreach ($transaction->details as $index => $detail)
                        <div class="mb-4 close p-4 border rounded-lg">
                            <div class="flex justify-between items-center mb-4">
                                <label class="block text-gray-700">Kategori</label>
                                <button type="button" class="remove-category text-red-600">✖</button>
                            </div>
                            <select name="details[{{ $index }}][category]" class="form-select rounded-md shadow-sm block w-full mb-4 category-select">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $detail->transaction_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <div class="grid grid-cols-4 gap-4 items-center mb-2">
                                <label class="block text-gray-700 col-span-2">Nama Transaksi</label>
                                <label class="block text-gray-700 col-span-2">Nominal (IDR)</label>
                            </div>
                            <div class="grid grid-cols-4 gap-4 mb-3">
                                <input type="text" name="details[{{ $index }}][name]" class="form-input rounded-md shadow-sm col-span-2" placeholder="Contoh: Mobil Agustus" value="{{ old('details.' . $index . '.name', $detail->name) }}">
                                <input type="number" name="details[{{ $index }}][amount]" class="form-input rounded-md shadow-sm col-span-1" placeholder="800.000" value="{{ old('details.' . $index . '.amount', $detail->value_idr) }}">
                            </div>
                        </div>
                        @endforeach
                        <button type="button" class="add-category bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Tambah Kategori</button>
                    </div>

                    <div id="preview-list" class="mt-8 mb-4 p-4 border rounded-lg">
                        <h4 class="text-lg font-medium">Pratinjau Transaksi Ditambahkan</h4>
                    </div>

                    <div class="mt-4 p-4 border rounded-lg">
                        <h4 class="text-lg font-medium">Total: IDR <span id="total-amount">0.00</span></h4>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="reset" class="bg-red-600 text-white px-4 py-2 rounded-md">Batal</button>
                        <button type="submit" class="ml-4 bg-blue-600 text-white px-4 py-2 rounded-md">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const detailsContainer = document.getElementById('details-container');
            const detailTemplate = document.querySelector('.detail-template');
            let detailIndex = {{ count($transaction->details) }}; // Menyesuaikan indeks sesuai jumlah detail saat ini

            document.querySelector('.add-category').addEventListener('click', function() {
                const newDetail = detailTemplate.cloneNode(true);
                newDetail.style.display = 'block';
                newDetail.classList.remove('detail-template');
    
                // Update indeks untuk input
                newDetail.querySelector('select[name="details[0][category]"]').setAttribute('name', `details[${detailIndex}][category]`);
                newDetail.querySelector('input[name="details[0][name]"]').setAttribute('name', `details[${detailIndex}][name]`);
                newDetail.querySelector('input[name="details[0][amount]"]').setAttribute('name', `details[${detailIndex}][amount]`);
    
                detailsContainer.appendChild(newDetail);
                detailIndex++; // Increment indeks setelah menambahkan detail baru
            });
    
            detailsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-category')) {
                    const detail = event.target.closest('.close'); 
                    if (detail) {
                        detail.remove(); 
                        updateTotal(); 
                    }
                }
            });

            // Fungsi untuk menghitung total
            function updateTotal() {
                let total = 0;
                document.querySelectorAll('input[name*="amount"]').forEach(function(input) {
                    const amount = parseFloat(input.value) || 0;
                    total += amount;
                });
                document.getElementById('total-amount').textContent = total.toFixed(2);
            }
        });
    </script>
        
</x-app-layout>
