<x-main>
    <x-slot:title>Report</x-slot:title>
    <x-slot:head>Laporan</x-slot:head>

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
            <h2 class="text-lg font-bold text-gray-800">Cetak Laporan Keuangan</h2>
        </div>

        <!-- Form Filter -->
        <div class="p-6 bg-gray-50/50">
            <form action="{{ route('report.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div class="w-full">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Mulai Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date', date('Y-m-01')) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                </div>
                <div class="w-full">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date', date('Y-m-t')) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                </div>
                <div class="w-full">
                    <button type="submit" class="w-full px-4 py-2 bg-teal-500 text-white rounded-lg text-sm font-medium hover:bg-teal-600 transition hover:cursor-pointer h-[38px] flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-main>
