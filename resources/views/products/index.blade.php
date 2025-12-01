<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-bold">Daftar Barang</h3>
                        <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Produk
                        </a>
                    </div>

                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="py-3 px-6">SKU</th>
                                    <th class="py-3 px-6">Nama Produk</th>
                                    <th class="py-3 px-6">Kategori</th>
                                    <th class="py-3 px-6 text-center">Stok</th>
                                    <th class="py-3 px-6 text-right">Harga Ritel</th>
                                    <th class="py-3 px-6 text-right">Harga Grosir</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="py-4 px-6">{{ $product->sku }}</td>
                                    <td class="py-4 px-6 font-medium text-gray-900">{{ $product->name }}</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            {{ $product->category->name ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="text-blue-600 font-bold">{{ $product->stock }}</span> {{ $product->unit }}
                                    </td>
                                    <td class="py-4 px-6 text-right">Rp {{ number_format($product->price_retail, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-right">Rp {{ number_format($product->price_semi_wholesale, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-right">Rp {{ number_format($product->price_wholesale, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center gap-4">

                                            <a href="{{ route('stocks.create', $product->id) }}"
                                                class="text-green-500 hover:text-green-600 transform hover:scale-110"
                                                title="Tambah Stok">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-500 hover:underline">
                                                Edit
                                            </a>

                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-4 px-6 text-center">Belum ada data produk.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>