<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('reports.sales') }}" method="GET" class="mb-6 bg-gray-50 p-4 rounded-lg flex items-end gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                            Filter Data
                        </button>
                    </form>

                    <div class="mb-6 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700">
                        <p class="font-bold">Total Omzet Periode Ini:</p>
                        <p class="text-2xl">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
                    </div>

                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                                <tr>
                                    <th class="py-3 px-6">No Nota</th>
                                    <th class="py-3 px-6">Tanggal & Jam</th>
                                    <th class="py-3 px-6">Kasir</th>
                                    <th class="py-3 px-6">Metode</th>
                                    <th class="py-3 px-6 text-right">Total</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sales as $sale)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="py-4 px-6 font-medium text-gray-900">{{ $sale->invoice_number }}</td>
                                    <td class="py-4 px-6">{{ $sale->created_at->format('d M Y H:i') }}</td>
                                    <td class="py-4 px-6">{{ $sale->user->name }}</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-500">
                                            {{ $sale->payment_method }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right font-bold text-green-600">
                                        Rp {{ number_format($sale->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('sales.print', $sale->id) }}" target="_blank" class="text-blue-600 hover:underline">
                                            Cetak Struk
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-8 px-6 text-center text-gray-400">
                                        Tidak ada transaksi pada periode tanggal ini.
                                    </td>
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