<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Produk') }}
        </h2>
    </x-slot>

    {{--<form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" accept=".csv" required>
    <button type="submit">Import Produk</button>
    </form>--}}


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h3 class="text-lg font-bold text-gray-700">Daftar Barang</h3>

                        <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 w-full md:w-auto">

                                <select name="category" class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full md:w-48 cursor-pointer">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>

                                <input type="text" name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari SKU atau Nama..."
                                    class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full md:w-64">

                                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition">
                                    Filter
                                </button>

                                @if(request('search') || request('category'))
                                <a href="{{ route('products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded border border-gray-300 text-center">
                                    Reset
                                </a>
                                @endif
                            </form>

                            <a href="{{ route('products.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                                + Tambah
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto relative rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th class="py-3 px-6">SKU</th>
                                    <th class="py-3 px-6">Nama Produk</th>
                                    <th class="py-3 px-6">Kategori</th>
                                    <th class="py-3 px-6 text-center">Stok</th>
                                    <th class="py-3 px-6 text-right">Harga Ritel</th>
                                    <th class="py-3 px-6 text-right">Harga Semi</th>
                                    <th class="py-3 px-6 text-right">Harga Grosir</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="py-4 px-6 font-mono text-xs">{{ $product->sku }}</td>
                                    <td class="py-4 px-6 font-medium text-gray-900">{{ $product->name }}</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            {{ $product->category->name ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="{{ $product->stock <= 5 ? 'text-red-600' : 'text-green-600' }} font-bold">
                                            {{ $product->stock }}
                                        </span>
                                        <span class="text-xs">{{ $product->unit }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-right">Rp {{ number_format($product->price_retail, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-right">Rp {{ number_format($product->price_semi_wholesale, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-right">Rp {{ number_format($product->price_wholesale, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('stocks.create', $product->id) }}" class="text-green-500 hover:text-green-700" title="Restok">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="py-8 px-6 text-center text-gray-400">
                                        Data tidak ditemukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>