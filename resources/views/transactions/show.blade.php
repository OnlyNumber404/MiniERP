<x-main>
    <x-slot:title>Detail Transaksi</x-slot:title>
    <x-slot:head>Detail Transaksi</x-slot:head>

    <div class="mb-6">
        <a href="{{ route('transaction.index') }}" class="inline-flex items-center text-sm font-medium text-teal-600 hover:text-teal-700 transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Transaksi
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar: Transaction Details -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800">Informasi Transaksi</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</label>
                        <p class="mt-1 text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($transaction->trans_date)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</label>
                        <p class="mt-1">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->category && $transaction->category->type == 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $transaction->category->cat_name ?? '-' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</label>
                        <p class="mt-1 text-xl font-bold {{ $transaction->category && $transaction->category->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</label>
                        <p class="mt-1 text-gray-700 leading-relaxed">{{ $transaction->desc }}</p>
                    </div>
                </div>
                <div class="p-6 bg-gray-50 border-t border-gray-100">
                    <a href="{{ route('transaction.file', $transaction->id) }}" download class="flex items-center justify-center w-full px-4 py-2 bg-teal-500 text-white rounded-lg text-sm font-medium hover:bg-teal-600 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Lampiran
                    </a>
                </div>
            </div>
        </div>

        <!-- Main: File Preview -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 shadow-xs overflow-hidden h-full flex flex-col">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Pratinjau Lampiran</h3>
                    <span class="text-xs text-gray-500">{{ strtoupper(pathinfo($transaction->path, PATHINFO_EXTENSION)) }} File</span>
                </div>
                <div class="flex-1 bg-gray-100 p-4 flex items-center justify-center min-h-[500px]">
                    @php
                        $extension = strtolower(pathinfo($transaction->path, PATHINFO_EXTENSION));
                    @endphp

                    @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                        <img src="{{ route('transaction.file', $transaction->id) }}" alt="Lampiran Transaksi" class="max-w-full h-auto shadow-md rounded-lg">
                    @elseif($extension === 'pdf')
                        <iframe src="{{ route('transaction.file', $transaction->id) }}" class="w-full h-full min-h-[600px] border-0 rounded-lg shadow-sm"></iframe>
                    @else
                        <div class="text-center p-8">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-600">Pratinjau tidak tersedia untuk format file ini.</p>
                            <a href="{{ route('transaction.file', $transaction->id) }}" class="mt-4 inline-block text-teal-600 font-medium hover:underline">Download File</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-main>
