<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hitung Penjumlahan Bilangan Fibonacci') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('transactions.fibonacci', ['n1' => 'N1', 'n2' => 'N2']) }}" method="GET">
                        @csrf
                        <div class="mb-4">
                            <label for="n1" class="block text-sm font-medium text-gray-700">Bilangan Pertama
                                (n1)</label>
                            <input type="number" name="n1" id="n1" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div class="mb-4">
                            <label for="n2" class="block text-sm font-medium text-gray-700">Bilangan Kedua
                                (n2)</label>
                            <input type="number" name="n2" id="n2" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Hitung</button>
                    </form>

                    @if (isset($result))
                        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            <h2 class="text-lg font-semibold">Hasil Penjumlahan:</h2>
                            <p class="mt-1">
                                {{ $fibo1 }} (Fibonacci dari {{ $n1 }}) + {{ $fibo2 }}
                                (Fibonacci dari {{ $n2 }}) = {{ $result }}
                            </p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Ada kesalahan!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
</x-app-layout>