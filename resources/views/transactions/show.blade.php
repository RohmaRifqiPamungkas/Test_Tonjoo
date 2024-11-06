<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">

                <section id="header-container" class="p-4">
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="flex flex-col">
                            <label class="block text-gray-700" for="description">Deskripsi</label>
                            <textarea id="description" name="description" class="form-input rounded-md shadow-sm mt-1 block w-full flex-grow"
                                placeholder="Transaksi Bulan Agustus" readonly>{{ old('description', $transaction->description) }}</textarea>
                        </div>
                        <div class="flex flex-col space-y-4">
                            <div>
                                <label class="block text-gray-700" for="code">Kode</label>
                                <input id="code" name="code" type="text"
                                    class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="LK2536"
                                    value="{{ old('code', $transaction->code) }}" readonly>
                            </div>
                            <div>
                                <label class="block text-gray-700" for="rate">Rate Euro</label>
                                <input id="rate" name="rate_euro" type="number" step="0.01"
                                    class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="15.000"
                                    value="{{ old('rate_euro', $transaction->rate_euro) }}" readonly>
                            </div>
                            <div>
                                <label class="block text-gray-700" for="date_paid">Tanggal Bayar</label>
                                <input id="date_paid" name="date_paid" type="date"
                                    class="form-input rounded-md shadow-sm mt-1 block w-full"
                                    value="{{ old('date_paid', \Carbon\Carbon::parse($transaction->date_paid)->format('Y-m-d')) }}"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold mt-4">Detail Transaksi</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah (IDR)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $totalValueIdr = 0;
                            @endphp
                            @foreach ($transaction->details as $detail)
                                @php
                                    $totalValueIdr += $detail->value_idr;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span
                                            class="px-3 py-1 text-xs text-white bg-gray-500 rounded-full">{{ optional($categories->find($detail->category))->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($detail->value_idr, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <div class="mt-4 text-right font-bold text-gray-800">
                        Total: Rp{{ number_format($totalValueIdr, 2) }}
                    </div>
                </section>

                <div class="mt-6">
                    <a href="{{ route('transactions.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>

    <x-footer-component />

</x-app-layout>
