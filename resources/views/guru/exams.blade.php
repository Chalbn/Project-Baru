<x-sidebar-layout>
    <x-slot name="header">Ujian Online (CBT)</x-slot>
    <x-slot name="description">Buat jadwal ujian dan masukkan soal untuk dikerjakan siswa secara online.</x-slot>

    <!-- Form Buat Ujian Baru -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8 max-w-3xl">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Buat Jadwal Ujian Baru</h3>
        
        <form action="#" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Mata Pelajaran</label>
                    <select name="subject_id" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required>
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($subjects as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->name }} (Kelas {{ $sub->grade_level }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Durasi (Menit)</label>
                    <input type="number" name="duration_minutes" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required placeholder="Contoh: 90">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Ujian</label>
                <input type="text" name="title" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required placeholder="Contoh: Ujian Tengah Semester (UTS) Ganjil">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi / Instruksi</label>
                <textarea name="description" rows="2" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" placeholder="Contoh: Kerjakan dengan jujur, waktu berjalan mundur..."></textarea>
            </div>

            <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-lg shadow transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Jadwal Ujian
            </button>
        </form>
    </div>

    <!-- Daftar Ujian -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Daftar Ujian Anda</h3>
        
        @if($exams->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="p-3 text-sm font-semibold text-gray-600">Judul Ujian</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Mata Pelajaran</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Durasi</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Bank Soal</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($exams as $exam)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 text-sm font-bold text-gray-800">{{ $exam->title }}</td>
                                <td class="p-3 text-sm text-gray-600">{{ $exam->subject->name }}</td>
                                <td class="p-3 text-sm text-gray-600">{{ $exam->duration_minutes }} Menit</td>
                                <td class="p-3 text-sm">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold uppercase tracking-wider">0 Soal</span>
                                </td>
                                <td class="p-3 text-sm flex gap-2">
                                    <button class="text-brand-600 hover:text-brand-800 font-medium text-xs border border-brand-200 hover:bg-brand-50 px-2 py-1 rounded transition">Kelola Soal</button>
                                    <button class="text-green-600 hover:text-green-800 font-medium text-xs border border-green-200 hover:bg-green-50 px-2 py-1 rounded transition">Lihat Nilai</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <p class="text-gray-500 text-sm">Belum ada ujian yang dibuat.</p>
            </div>
        @endif
    </div>
</x-sidebar-layout>
