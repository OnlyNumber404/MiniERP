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
            <button onclick="openModal('addTransactionModal')" class="px-4 py-2 bg-teal-500 text-white rounded-lg text-sm font-medium hover:bg-teal-600 transition hover:cursor-pointer">
                + Tambah Transaksi
            </button>
        </div>

        <!-- Form Filter -->
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <form action="{{ route('transaction.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1 w-full">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Mulai Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                </div>
                <div class="flex-1 w-full">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                </div>
                <div class="flex-1 w-full">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Kategori</label>
                    <select name="category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500 hover:cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->cat_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 w-full">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Jenis</label>
                    <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500 hover:cursor-pointer">
                        <option value="">Semua Jenis</option>
                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>
                <div class="flex gap-2 w-full md:w-auto mt-4 md:mt-0">
                    <button type="submit" class="w-full md:w-auto px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-gray-900 transition hover:cursor-pointer h-[38px]">
                        Terapkan
                    </button>
                    @if(request()->anyFilled(['start_date', 'end_date', 'category_id', 'type']))
                        <a href="{{ route('transaction.index') }}" class="w-full md:w-auto px-4 py-2 bg-white border border-gray-300 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 transition hover:cursor-pointer h-[38px] flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Kategori</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Deskripsi</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-right">Jumlah</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">Aksi</th>
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
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-2">
                                    @if ($transaction->path)
                                        <a href="{{ route('transaction.show', $transaction->id) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-teal-500 text-white rounded-md text-xs font-medium hover:bg-teal-600 transition hover:cursor-pointer" title="Lihat Lampiran">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Detail
                                        </a>
                                    @else
                                        <button disabled class="inline-flex items-center gap-1 px-3 py-1 bg-gray-200 text-gray-400 rounded-md text-xs font-medium cursor-not-allowed" title="Tidak ada lampiran">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                            </svg>
                                            Detail
                                        </button>
                                    @endif
                                    <form action="{{ route('transaction.delete', $transaction->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 bg-red-500 text-white rounded-md text-xs font-medium hover:bg-red-600 transition hover:cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">Belum ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4 flex justify-center">
         {{ $transactions->links() }}
    </div>

    <!-- Modal Tambah Transaksi -->
    <div id="addTransactionModal" class="fixed inset-0 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg border-0 w-full max-w-md mx-4 overflow-hidden">
            <form action="{{ route('transaction.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col">
                @csrf
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Tambah Transaksi Baru</h3>
                    <button type="button" onclick="closeModal('addTransactionModal')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5 hover:cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 flex flex-col space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="trans_date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500" value="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500 hover:cursor-pointer">
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
                        <input type="number" name="amount" min="0" step="1000" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar</label>
                        <input type="file" accept=".png, .jpg, .jpeg, .pdf" name="path" class="block w-full text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-lg file:border-0
                          file:text-sm file:font-semibold
                          file:bg-teal-50 file:text-teal-700
                          hover:file:bg-teal-100
                          border border-gray-300 rounded-lg focus:outline-hidden focus:ring-2 focus:ring-teal-500 cursor-pointer">
                    </div>
                </div>
                <div class="p-6 border-t border-gray-100 flex justify-end space-x-3 bg-gray-50">
                    <button type="button" onclick="closeModal('addTransactionModal')" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:border-red-600 hover:text-red-600 hover:cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-lg text-sm font-medium hover:bg-teal-600 hover:cursor-pointer">Simpan</button>
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
