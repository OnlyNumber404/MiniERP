<x-main>
    <x-slot:title>Dashboard</x-slot:title>
    <x-slot:head>Dashboard</x-slot:head>

    <!-- Top Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card Total Saldo -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-xs">
            <h3 class="text-gray-600 text-sm font-bold mb-2 uppercase tracking-wide">Total Saldo</h3>
            <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($total_saldo, 2, ',', '.') }}</p>
        </div>
        <!-- Card Pemasukkan -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-xs">
            <h3 class="text-green-500 text-sm font-bold mb-2 uppercase tracking-wide">Pemasukkan</h3>
            <p class="text-3xl font-bold text-green-500">Rp {{ number_format($pemasukan, 2, ',', '.') }}</p>
        </div>
        <!-- Card Pengeluaran -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-xs">
            <h3 class="text-red-500 text-sm font-bold mb-2 uppercase tracking-wide">Pengeluaran</h3>
            <p class="text-3xl font-bold text-red-500">Rp {{ number_format($pengeluaran, 2, ',', '.') }}</p>
        </div>
    </div>

    <!-- Last Transactions List -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-xs">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-800">Transaksi Terakhir</h2>
        </div>
        <div class="p-6">
            <div class="flex flex-col space-y-4">
                @forelse($recent_transaction as $transaction)
                <!-- Transaction Item -->
                <div class="flex justify-between items-center pb-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                    <div>
                        <h4 class="text-gray-800 font-semibold">{{ $transaction->desc }}</h4>
                        <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::parse($transaction->trans_date)->format('d M Y') }}</p>
                    </div>
                    <div class="font-bold {{ $transaction->category && $transaction->category->type == 'income' ? 'text-green-500' : 'text-red-500' }}">
                        Rp {{ number_format($transaction->amount, 2, ',', '.') }}
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-500 py-4">
                    Belum ada transaksi.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-main>