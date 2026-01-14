<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Riwayat Stok') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('reports.stock') }}" method="GET" class="mb-6 bg-gray-50 p-4 rounded-lg flex items-end gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="border-gray-300 rounded-md shadow-sm">
                        </div>
                        <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Filter
                        </button>
                    </form>

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                                <tr>
                                    <th class="py-3 px-6">Tanggal</th>
                                    <th class="py-3 px-6">Produk</th>
                                    <th class="py-3 px-6 text-center">Tipe</th>
                                    <th class="py-3 px-6 text-center">Jml</th>
                                    <th class="py-3 px-6">Oleh</th>
                                    <th class="py-3 px-6">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($histories as $history)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="py-4 px-6">
                                        {{ \Carbon\Carbon::parse($history->restock_date)->format('d M Y') }}
                                        <div class="text-xs text-gray-400">{{ $history->created_at->format('H:i') }}</div>
                                    </td>

                                    <td class="py-4 px-6 font-medium text-gray-900">
                                        {{ $history->product->name ?? 'Produk Dihapus' }}
                                    </td>

                                    <td class="py-4 px-6 text-center">
                                        @if($history->type == 'Restok')
                                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded">RESTOK</span>
                                        @elseif($history->type == 'Penjualan')
                                        <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded">TERJUAL</span>
                                        @else
                                        <span class="bg-gray-100 text-gray-800 text-xs font-bold px-2.5 py-0.5 rounded">{{ $history->type }}</span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6 text-center font-bold text-base">
                                        @if($history->quantity_change > 0)
                                        <span class="text-green-600">+{{ $history->quantity_change }}</span>
                                        @else
                                        <span class="text-red-500">{{ $history->quantity_change }}</span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6 text-sm">
                                        {{ $history->user->name ?? 'Sistem' }}
                                    </td>

                                    <td class="py-4 px-6 text-xs italic text-gray-500">
                                        {{ $history->notes ?? '-' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-gray-400">Belum ada riwayat stok.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>