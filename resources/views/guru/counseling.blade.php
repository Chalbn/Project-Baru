<x-sidebar-layout>
    <x-slot name="header">Bimbingan Lomba & Beasiswa</x-slot>
    <x-slot name="description">Kelola program bimbingan untuk siswa berprestasi.</x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8 max-w-3xl">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Buat Program Bimbingan Baru</h3>
        
        <form action="{{ route('guru.counseling.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Program</label>
                    <select name="type" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required>
                        <option value="lomba">Bimbingan Lomba (Olimpiade, dll)</option>
                        <option value="beasiswa">Informasi & Bimbingan Beasiswa</option>
                        <option value="lainnya">Program Khusus Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Target Siswa</label>
                    <input type="text" name="target_students" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" placeholder="Contoh: Siswa Kelas 11 & 12 IPA">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Program</label>
                <input type="text" name="title" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required placeholder="Contoh: Bimbingan OSN Matematika 2026">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi & Syarat</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required placeholder="Tuliskan syarat dan jadwal bimbingan..."></textarea>
            </div>

            <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-lg shadow transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Publikasikan Program
            </button>
        </form>
    </div>

    <!-- Daftar Program -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Program Bimbingan Anda</h3>
        @if(isset($programs) && $programs->count() > 0)
            <ul class="space-y-4">
                @foreach($programs as $prog)
                    <li class="border rounded-lg p-4 hover:bg-gray-50 flex flex-col gap-3" x-data="{ open: false }">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-brand-600 mb-1 block">{{ $prog->type }}</span>
                                <h4 class="font-bold text-gray-800">{{ $prog->title }}</h4>
                                <p class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $prog->description }}</p>
                            </div>
                            <button @click="open = !open" class="px-3 py-1 bg-brand-100 text-brand-700 text-sm font-bold rounded hover:bg-brand-200 whitespace-nowrap">
                                <span x-text="open ? 'Tutup Pendaftar' : 'Lihat Pendaftar ({{ $prog->students->count() }})'"></span>
                            </button>
                        </div>
                        <div x-show="open" x-collapse x-cloak class="mt-4 pt-4 border-t border-gray-100">
                            <h5 class="text-sm font-semibold text-gray-700 mb-2">Daftar Siswa yang Mendaftar:</h5>
                            @if($prog->students->count() > 0)
                                <ul class="list-disc list-inside text-sm text-gray-600">
                                    @foreach($prog->students as $student)
                                        <li>{{ $student->name }} <span class="text-xs text-gray-400">({{ $student->email }})</span></li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-gray-400 italic">Belum ada pendaftar.</p>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 text-sm text-center py-4">Belum ada program bimbingan yang dibuat.</p>
        @endif
    </div>
</x-sidebar-layout>
