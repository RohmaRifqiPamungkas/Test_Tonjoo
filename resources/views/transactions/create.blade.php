<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Data Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <form id="transaction-form" action="{{ route('transactions.store') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <h4>{{ $errors->first() }}</h4>
                    @endif

                    <!-- Header Transaksi -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="flex flex-col">
                            <label class="block text-gray-700" for="description">Deskripsi</label>
                            <textarea id="description" name="description" class="form-input rounded-md shadow-sm mt-1 block w-full flex-grow"
                                placeholder="Transaksi Bulan Agustus">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex flex-col space-y-4">
                            <div>
                                <label class="block text-gray-700" for="code">Kode</label>
                                <input id="code" name="code" type="text"
                                    class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="LK2536"
                                    value="{{ old('code') }}">
                                @error('code')
                                    <div class="text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700" for="rate">Rate Euro</label>
                                <input id="rate" name="rate_euro" type="number" step="0.01"
                                    class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="15.000"
                                    value="{{ old('rate_euro') }}">
                                @error('rate_euro')
                                    <div class="text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700" for="date_paid">Tanggal Bayar</label>
                                <input id="date_paid" name="date_paid" type="date"
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    value="{{ old('date_paid') }}">
                                @error('date_paid')
                                    <div class="text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Detail Transaksi -->
                    <div id="details-container">
                        @php
                            $oldDetails = old('details', []);
                        @endphp

                        <div class="mb-4 close p-4 border rounded-lg detail-template" style="display: none;">
                            <div class="flex justify-between items-center mb-4">
                                <label class="block text-gray-700">Kategori</label>
                                <button type="button" class="remove-category text-red-600">✖</button>
                            </div>
                            <select name="details[0][category]"
                                class="form-select rounded-md shadow-sm block w-full mb-4 category-select">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('details.0.category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('details.0.category')
                                <div class="text-red-600">{{ $message }}</div>
                            @enderror

                            <div class="grid grid-cols-4 gap-4 items-center mb-2">
                                <label class="block text-gray-700 col-span-2">Nama Transaksi</label>
                                <label class="block text-gray-700 col-span-2">Nominal (IDR)</label>
                            </div>
                            <div class="grid grid-cols-4 gap-4 mb-3">
                                <input type="text" name="details[0][name]"
                                    class="form-input rounded-md shadow-sm col-span-2"
                                    placeholder="Contoh: Mobil Agustus" value="{{ old('details.0.name') }}">
                                @error('details.0.name')
                                    <div class="text-red-600 col-span-2">{{ $message }}</div>
                                @enderror

                                <input type="number" name="details[0][amount]"
                                    class="form-input rounded-md shadow-sm col-span-1" placeholder="800.000"
                                    value="{{ old('details.0.amount') }}">
                                @error('details.0.amount')
                                    <div class="text-red-600 col-span-1">{{ $message }}</div>
                                @enderror

                                <button type="button"
                                    class="add-transaction ml-4 bg-blue-600 text-white px-4 py-2 rounded-md">Tambah</button>
                            </div>

                        </div>
                        <button type="button"
                            class="add-category bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Tambah
                            Kategori</button>
                    </div>

                    <!-- Pratinjau dan Total -->
                    <div id="preview-list" class="mt-8 mb-4 p-4 border rounded-lg">
                        <h4 class="text-lg font-medium">Pratinjau Transaksi Ditambahkan</h4>
                    </div>

                    <div class="mt-4 p-4 border rounded-lg">
                        <h4 class="text-lg font-medium">Total: IDR <span id="total-amount">0.00</span></h4>
                    </div>

                    <!-- Tombol Simpan dan Batal -->
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
            const previewList = document.getElementById('preview-list');
            let detailIndex = 0;

            document.querySelector('.add-category').addEventListener('click', function() {
                const newDetail = detailTemplate.cloneNode(true);
                newDetail.style.display = 'block';
                newDetail.classList.remove('detail-template');

                newDetail.querySelector('select[name="details[0][category]"]').setAttribute(
                    'name', `details[${detailIndex}][category]`);
                newDetail.querySelector('input[name="details[0][name]"]').setAttribute(
                    'name', `details[${detailIndex}][name]`);
                newDetail.querySelector('input[name="details[0][amount]"]').setAttribute(
                    'name', `details[${detailIndex}][amount]`);

                const amountInput = newDetail.querySelector('input[name^="details"][name$="[amount]"]');
                amountInput.addEventListener('input', updateTotal);

                detailsContainer.insertBefore(newDetail, this);
                detailIndex++;
            });

            detailsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-category')) {
                    const detail = event.target.closest('.close');
                    if (detail) {
                        detail.remove();
                        updateTotal();
                    }
                }

                if (event.target.classList.contains('add-transaction')) {
                    const detail = event.target.closest('.close');
                    const nameInput = detail.querySelector('input[name^="details"][name$="[name]"]');
                    const amountInput = detail.querySelector('input[name^="details"][name$="[amount]"]');
                    const categorySelect = detail.querySelector('.category-select');

                    if (nameInput.value.trim() && amountInput.value.trim()) {
                        const amount = parseFloat(amountInput.value) || 0;
                        const previewItem = document.createElement('div');
                        previewItem.className =
                            'preview-item bg-gray-100 p-2 mb-2 rounded-md flex justify-between items-center';
                        previewItem.innerHTML = `<span>${categorySelect.options[categorySelect.selectedIndex].text}: ${nameInput.value} - IDR ${amount.toFixed(2)}</span><button type="button" class="delete-preview-item text-red-600">✖</button>`;
                        previewList.appendChild(previewItem);

                        nameInput.value = '';
                        amountInput.value = '';
                        updateTotal();
                    } else {
                        alert('Pastikan Nama Transaksi dan Nominal telah terisi dengan benar.');
                    }
                }
            });

            previewList.addEventListener('click', function(event) {
                if (event.target.classList.contains('delete-preview-item')) {
                    const previewItem = event.target.closest('.preview-item');
                    previewItem.remove();
                    updateTotal();
                }
            });

            document.getElementById('transaction-form').addEventListener('submit', function(event) {
                const allDetails = document.querySelectorAll('.close:not(.detail-template)');
                allDetails.forEach(function(detail, index) {
                    detail.querySelector('select[name^="details"][name$="[category]"]')
                        .setAttribute('name', `details[${index}][category]`);
                    detail.querySelector('input[name^="details"][name$="[name]"]').setAttribute(
                        'name', `details[${index}][name]`);
                    detail.querySelector('input[name^="details"][name$="[amount]"]').setAttribute(
                        'name', `details[${index}][amount]`);
                });
            });

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
