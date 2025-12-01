<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Stok: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('stocks.store', $product->id) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2 text-gray-500">Stok Saat Ini</label>
                            <div class="text-2xl font-bold text-blue-600">{{ $product->stock }} {{ $product->unit }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2">Jumlah Penambahan</label>
                            <input type="number" name="quantity_change" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required min="1" placeholder="Contoh: 10">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2">Tanggal Restok</label>
                            <input type="date" name="restock_date" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" class="w-full border-gray-300 rounded-md shadow-sm" rows="2" placeholder="Contoh: Beli dari Toko A"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</a>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                                Simpan Penambahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>