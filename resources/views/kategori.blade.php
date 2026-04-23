<x-main>
    <x-slot:title>Category</x-slot:title>
    <x-slot:head>Kategori</x-slot:head>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-sm relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-sm relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
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
            <h2 class="text-lg font-bold text-gray-800">Daftar Kategori</h2>
            <button onclick="openModal('addCategoryModal')" class="px-4 py-2 bg-teal-500 text-white rounded-lg text-sm font-medium hover:bg-teal-600 transition">
                + Tambah Kategori
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="p-4 text-sm font-semibold text-gray-600">Nama Kategori</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Tipe</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="border-b border-gray-50 hover:bg-gray-50">
                        <td class="p-4 text-gray-800">{{ $category->cat_name }}</td>
                        <td class="p-4">
                            @if($category->type == 'income')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Pemasukkan</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="p-4 flex justify-center space-x-2">
                            <button onclick="openEditModal({{ $category->id }}, '{{ $category->cat_name }}', '{{ $category->type }}')" class="px-3 py-1 bg-amber-500 text-white rounded-md text-xs hover:bg-amber-600 transition">Edit</button>
                            <form action="{{ route('category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md text-xs hover:bg-red-600 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">Belum ada data kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div id="addCategoryModal" class="fixed inset-0 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg border-0 w-full max-w-md mx-4 overflow-hidden">
            <form action="{{ route('category.store') }}" method="POST" class="flex flex-col">
                @csrf
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Tambah Kategori Baru</h3>
                    <button type="button" onclick="closeModal('addCategoryModal')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 flex flex-col space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" name="cat_name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                        <select name="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                            <option value="expense">Pengeluaran</option>
                            <option value="income">Pemasukkan</option>
                        </select>
                    </div>
                </div>
                <div class="p-6 border-t border-gray-100 flex justify-end space-x-3 bg-gray-50">
                    <button type="button" onclick="closeModal('addCategoryModal')" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-lg text-sm font-medium hover:bg-teal-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="editCategoryModal" class="fixed inset-0 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg border-0 w-full max-w-md mx-4 overflow-hidden">
            <form id="editForm" method="POST" class="flex flex-col">
                @csrf
                @method('PUT')
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Edit Kategori</h3>
                    <button type="button" onclick="closeModal('editCategoryModal')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 flex flex-col space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" id="edit_cat_name" name="cat_name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                        <select id="edit_type" name="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-800 focus:outline-hidden focus:ring-2 focus:ring-teal-500">
                            <option value="expense">Pengeluaran</option>
                            <option value="income">Pemasukkan</option>
                        </select>
                    </div>
                </div>
                <div class="p-6 border-t border-gray-100 flex justify-end space-x-3 bg-gray-50">
                    <button type="button" onclick="closeModal('editCategoryModal')" class="px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-teal-500 text-white rounded-lg text-sm font-medium hover:bg-teal-600">Simpan Perubahan</button>
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

        function openEditModal(id, name, type) {
            const form = document.getElementById('editForm');
            form.action = `/category/${id}`;
            document.getElementById('edit_cat_name').value = name;
            document.getElementById('edit_type').value = type;
            
            openModal('editCategoryModal');
        }
    </script>
</x-main>