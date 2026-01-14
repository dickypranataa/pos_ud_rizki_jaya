<div class="flex h-screen bg-gray-100 overflow-hidden">

    <div class="w-2/3 flex flex-col border-r border-gray-200 bg-white">

        <div class="p-4 border-b border-gray-200 bg-gray-50">

            <div class="flex gap-4 mb-4">
                @foreach($priceTypes as $type)
                <button
                    wire:click="selectPriceType({{ $type->id }})"
                    class="flex-1 py-3 px-4 rounded-lg font-bold transition shadow-sm
                    {{ $selectedPriceTypeId == $type->id ? 'bg-blue-600 text-white ring-2 ring-blue-300' : 'bg-white text-gray-700 border hover:bg-gray-100' }}">
                    {{ $type->name }}
                </button>
                @endforeach
            </div>

            <div class="relative">
                <input type="text" wire:model.live="search"
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Cari Nama Barang atau SKU (Scan Barcode)...">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4">
            @if(!$selectedPriceTypeId)
            <div class="flex flex-col items-center justify-center h-full text-gray-400">
                <p class="text-xl font-semibold">Pilih "Tipe Harga" Terlebih Dahulu</p>
                <p class="text-sm">Klik tombol di atas (Ritel / Grosir) untuk memulai.</p>
            </div>
            @else
            <div class="grid grid-cols-3 gap-4">
                @foreach($products as $product)
                <div wire:click="addToCart({{ $product->id }})"
                    class="bg-white border rounded-lg shadow-sm p-4 cursor-pointer hover:ring-2 hover:ring-blue-500 transition relative group">

                    <span class="absolute top-2 right-2 bg-gray-100 text-xs font-bold px-2 py-1 rounded text-gray-600">
                        Stok: {{ $product->stock }}
                    </span>

                    <h3 class="font-bold text-gray-800 mb-1">{{ $product->name }}</h3>
                    <p class="text-xs text-gray-500 mb-2">{{ $product->sku }}</p>

                    <p class="text-blue-600 font-bold text-lg">
                        @if($selectedPriceTypeId == 1) Rp {{ number_format($product->price_retail, 0, ',', '.') }}
                        @elseif($selectedPriceTypeId == 2) Rp {{ number_format($product->price_semi_wholesale, 0, ',', '.') }}
                        @elseif($selectedPriceTypeId == 3) Rp {{ number_format($product->price_wholesale, 0, ',', '.') }}
                        @endif
                    </p>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <div class="w-1/3 flex flex-col bg-gray-50 border-l">

        <div class="p-4 bg-blue-600 text-white shadow">
            <h2 class="text-lg font-bold">Keranjang Belanja</h2>
            <p class="text-sm opacity-80">{{ date('d F Y') }} | Kasir: {{ Auth::user()->name }}</p>
        </div>

        <div class="flex-1 overflow-y-auto p-2">
            @if(empty($cart))
            <div class="text-center text-gray-400 mt-10">Keranjang Kosong</div>
            @else
            @foreach($cart as $id => $item)
            <div class="bg-white p-3 rounded shadow-sm mb-2 flex justify-between items-center">
                <div class="flex-1">
                    <h4 class="font-bold text-sm">{{ $item['name'] }}</h4>
                    <p class="text-xs text-gray-500">@ Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                </div>

                <div class="flex items-center gap-2">
                    <button wire:click="decreaseQty({{ $id }})" class="w-6 h-6 bg-gray-200 rounded hover:bg-red-200 text-red-600 font-bold">-</button>
                    <span class="text-sm font-bold w-4 text-center">{{ $item['qty'] }}</span>
                    <button wire:click="increaseQty({{ $id }})" class="w-6 h-6 bg-gray-200 rounded hover:bg-green-200 text-green-600 font-bold">+</button>
                </div>

                <div class="text-right ml-3 w-20">
                    <p class="font-bold text-sm">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</p>
                    <button wire:click="removeItem({{ $id }})" class="text-xs text-red-500 hover:underline">Hapus</button>
                </div>
            </div>
            @endforeach
            @endif
        </div>

        <div class="p-4 bg-white border-t shadow-lg">
            @if (session()->has('error'))
            <div class="bg-red-100 text-red-700 p-2 rounded mb-2 text-sm">{{ session('error') }}</div>
            @endif
            @if (session()->has('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-2 text-sm">{{ session('success') }}</div>
            @endif

            <div class="flex justify-between text-xl font-bold text-gray-800 mb-4">
                <span>Total:</span>
                <span>Rp {{ number_format($this->total, 0, ',', '.') }}</span>
            </div>

            <div class="mb-3">
                <label class="text-xs font-bold text-gray-500 uppercase block mb-1">Metode Pembayaran</label>
                <div class="flex gap-2">

                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="metode_pembayaran" wire:model.live="paymentMethod" value="Tunai" class="peer sr-only">
                        <div class="text-center py-2 border rounded peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 hover:bg-gray-50 transition">
                            Tunai
                        </div>
                    </label>

                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="metode_pembayaran" wire:model.live="paymentMethod" value="Transfer" class="peer sr-only">
                        <div class="text-center py-2 border rounded peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 hover:bg-gray-50 transition">
                            Transfer
                        </div>
                    </label>

                </div>
            </div>

            <div class="mb-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Bayar (Rp)</label>
                <input type="number" wire:model.live="paymentAmount" class="w-full border-gray-300 rounded p-2 text-right font-mono font-bold text-lg" placeholder="0">
            </div>

            <div class="flex justify-between text-sm font-bold text-gray-600 mb-4">
                <span>Kembalian:</span>
                <span class="{{ $this->change < 0 ? 'text-red-500' : 'text-green-600' }}">
                    Rp {{ number_format($this->change, 0, ',', '.') }}
                </span>
            </div>

            <button wire:click="checkout"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded shadow-lg transition disabled:opacity-50"
                {{ empty($cart) ? 'disabled' : '' }}>
                SELESAIKAN TRANSAKSI
            </button>
        </div>

    </div>
</div>