<x-main>
    <x-slot:title>Transaction</x-slot:title>
    <x-slot:head>Transaksi</x-slot:head>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-sm relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-sm relative" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 shadow-xs mb-8">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-800">Daftar Transaksi</h2>
            <button onclick="openModal('addTransactionModal')" class="px-4 py-2 bg-teal-500 text-white rounded-lg text-sm font-medium hover:bg-teal-600 transition">
                + Tambah Transaksi
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Kategori</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Deskripsi</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr class="border-b border-gray-50 hover:bg-gray-50">
                        <td class="p-4 text-gray-800">{{ \Carbon\Carbon::parse($transaction->trans_date)->format('d M Y') }}</td>
                        <td class="p-4 text-gray-800">
                            {{ $transaction->category->cat_name ?? '-' }}
                        </td>
                        <td class="p-4 text-gray-600">{{ $transaction->desc }}</td>
                        <td class="p-4 text-right font-semibold {{ $transaction->category && $transaction->category->type == 'income' ? 'text-green-500' : 'text-red-500' }}">
                            Rp {{ number_format($transaction->amount, 2, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">Belum ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Transaksi -->
    <div id="addTransactionModal" class="fixed inset-0 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg border-0 w-full max-w-md mx-4 overflow-hidden">
            <form action="{{ route('transaction.store') }}" method="POST" class="flex flex-col">
                @csrf
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Tambah Transaksi Baru</h3>
                    <button type="button" onclick="closeModal('addTransactionModal')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 flex flex-col space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="trans_date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500" value="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->cat_name }} ({{ $category->type == 'income' ? 'Pemasukkan' : 'Pengeluaran' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <input type="text" name="desc" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
                        <input type="number" name="amount" min="0" step="0.01" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
                <div class="p-6 border-t border-gray-100 flex justify-end space-x-3 bg-gray-50">
                    <button type="button" onclick="closeModal('addTransactionModal')" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-lg text-sm font-medium hover:bg-teal-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</x-main>