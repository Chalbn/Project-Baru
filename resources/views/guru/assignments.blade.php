<x-sidebar-layout>
    <x-slot name="header">Manajemen Tugas</x-slot>
    <x-slot name="description">Kelola pemberian tugas dan periksa pengumpulan siswa.</x-slot>

    <!-- Form Buat Tugas Baru -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Buat Tugas Baru</h3>
        
        <form action="{{ route('guru.assignments.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Tugas</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Mulai</label>
                    <input type="time" name="start_time" value="{{ date('H:i') }}" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Batas Waktu (Selesai)</label>
                    <input type="time" name="expires_time" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Tugas</label>
                <input type="text" name="title" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required placeholder="Contoh: Latihan Bab 3 Persamaan Kuadrat">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Tugas</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required placeholder="Tuliskan instruksi lengkap tugas di sini..."></textarea>
            </div>

            <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-lg shadow transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Terbitkan Tugas
            </button>
        </form>
    </div>

    <!-- Daftar Tugas -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Tugas yang Sedang Berjalan</h3>
        
        @if($assignments->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($assignments as $assign)
                    <div x-data="{ open: false }" class="border rounded-lg p-5 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-bold text-gray-800 text-lg leading-tight">{{ $assign->title }}</h4>
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-[10px] font-bold uppercase tracking-wider whitespace-nowrap">Tenggat: {{ \Carbon\Carbon::parse($assign->due_date)->format('d M') }}</span>
                            </div>
                            <p class="text-xs text-brand-600 font-semibold mb-3">{{ $assign->subject->name }} - Kelas {{ $assign->subject->grade_level }}</p>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $assign->description }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between border-t border-gray-100 pt-3 mt-2">
                            <span class="text-sm font-semibold text-gray-700">Terkumpul: <span class="text-green-600">{{ $assign->submissions->count() }} Siswa</span></span>
                            <button @click="open = !open" type="button" class="text-brand-600 hover:text-brand-800 font-semibold text-sm transition flex items-center gap-1">
                                Lihat Berkas
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </div>

                        <!-- Daftar Berkas dan Input Nilai -->
                        <div x-show="open" class="mt-4 border-t pt-4" style="display: none;">
                            @if($assign->submissions->count() > 0)
                                <ul class="space-y-3">
                                    @foreach($assign->submissions as $submission)
                                        <li class="bg-gray-50 rounded-lg p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border border-gray-200">
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-gray-800 text-sm">{{ $submission->student->name }}</span>
                                                <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="text-xs text-brand-600 hover:underline flex items-center gap-1 mt-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                    Buka File
                                                </a>
                                            </div>
                                            <form action="{{ route('guru.assignments.score', $submission->id) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                <input type="number" name="score" value="{{ $submission->score }}" min="0" max="100" class="w-20 text-sm rounded border-gray-300 focus:border-brand-500 focus:ring-brand-500 py-1 px-2" placeholder="Nilai">
                                                <button type="submit" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded shadow transition">Simpan</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-xs text-gray-500 text-center italic">Belum ada siswa yang mengumpulkan tugas ini.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6">
                <p class="text-gray-500 text-sm">Belum ada tugas yang dibuat.</p>
            </div>
        @endif
    </div>
</x-sidebar-layout>
