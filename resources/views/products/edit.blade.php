<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Produk: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT') <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold mb-2">SKU</label>
                                <input type="text" name="sku" value="{{ $product->sku }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2">Nama Produk</label>
                                <input type="text" name="name" value="{{ $product->name }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold mb-2">Kategori</label>
                                <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2">Satuan</label>
                                <select name="unit" class="w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="pcs" {{ $product->unit == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                    <option value="dus" {{ $product->unit == 'dus' ? 'selected' : '' }}>Dus</option>
                                    <option value="meter" {{ $product->unit == 'meter' ? 'selected' : '' }}>Meter</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                {{-- tidak bisa di edit --}}
                                <label class="block text-sm font-bold mb-2" >Stok Saat Ini</label>
                                <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border-gray-500 rounded-md shadow-sm" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2">Harga Modal</label>
                                <input type="number" name="purchase_price" value="{{ $product->purchase_price }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>

                        <hr class="my-6">
                        <h3 class="font-bold text-lg mb-4 text-blue-600">Harga Jual</h3>

                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-bold mb-2">Harga Ritel</label>
                                <input type="number" name="price_retail" value="{{ $product->price_retail }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2">Harga Semi</label>
                                <input type="number" name="price_semi_wholesale" value="{{ $product->price_semi_wholesale }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2">Harga Grosir</label>
                                <input type="number" name="price_wholesale" value="{{ $product->price_wholesale }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Produk</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>