<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-xs font-bold uppercase mb-1">Omzet Hari Ini</div>
                    <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-xs font-bold uppercase mb-1">Transaksi Hari Ini</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $transaksiHariIni }} <span class="text-sm font-normal">Nota</span></div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 text-xs font-bold uppercase mb-1">Total Jenis Produk</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $totalProduk }} <span class="text-sm font-normal">Item</span></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-red-50 border-b border-red-100 flex justify-between items-center">
                        <h3 class="font-bold text-red-700">⚠️ Peringatan Stok Menipis (< 5)</h3>
                    </div>
                    <div class="p-4">
                        @if($stokMenipis->count() > 0)
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th class="py-2 px-2">Produk</th>
                                    <th class="py-2 px-2 text-center">Sisa Stok</th>
                                    <th class="py-2 px-2 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stokMenipis as $item)
                                <tr class="border-b">
                                    <td class="py-2 px-2 font-medium text-gray-900">{{ $item->name }}</td>
                                    <td class="py-2 px-2 text-center font-bold text-red-600">{{ $item->stock }}</td>
                                    <td class="py-2 px-2 text-right">
                                        <a href="{{ route('stocks.create', $item->id) }}" class="text-blue-600 hover:underline text-xs">Restok</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-green-600 text-center py-4">Aman! Tidak ada stok yang kritis.</p>
                        @endif
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-gray-50 border-b border-gray-100">
                        <h3 class="font-bold text-gray-700">Transaksi Terakhir</h3>
                    </div>
                    <div class="p-4">
                        <ul class="divide-y divide-gray-100">
                            @foreach($transaksiTerbaru as $sale)
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $sale->invoice_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $sale->created_at->diffForHumans() }} oleh {{ $sale->user->name }}</p>
                                </div>
                                <div class="text-sm font-bold text-gray-800">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>