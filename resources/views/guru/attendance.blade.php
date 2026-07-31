<x-sidebar-layout>
    <x-slot name="header">Manajemen Absensi Siswa</x-slot>
    <x-slot name="description">Buka sesi absensi untuk mata pelajaran Anda hari ini.</x-slot>

    <!-- Buka Absensi Baru -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Buka Sesi Absensi Baru</h3>
        <form action="{{ route('guru.attendance.store') }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
            @csrf
            <div class="w-full md:w-1/4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Absensi</label>
                <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required>
            </div>
            <div class="w-full md:w-1/4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Mulai</label>
                <input type="time" name="start_time" value="{{ date('H:i') }}" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required>
            </div>
            <div class="w-full md:w-1/4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Batas Waktu (Selesai)</label>
                <input type="time" name="expires_time" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required>
            </div>
            <div class="w-full md:w-1/4">
                <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 px-4 rounded-lg shadow transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Buka Absensi Sekarang
                </button>
            </div>
        </form>
    </div>

    <!-- Riwayat Absensi -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Riwayat & Sesi Berjalan</h3>
        
        @if($attendances->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="p-3 text-sm font-semibold text-gray-600">Tanggal</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Mata Pelajaran</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Status Sesi</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Jml. Siswa Hadir</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($attendances as $att)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 text-sm text-gray-800 font-medium">{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                                <td class="p-3 text-sm text-gray-800">{{ $att->subject->name }}</td>
                                <td class="p-3 text-sm">
                                    @if($att->is_open)
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold uppercase tracking-wider">Dibuka (Live)</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-bold uppercase tracking-wider">Ditutup</span>
                                    @endif
                                </td>
                                <td class="p-3 text-sm font-bold text-brand-600">{{ $att->records->where('status', 'hadir')->count() }} Siswa</td>
                                <td class="p-3 text-sm">
                                    <a href="{{ route('guru.attendance.show', $att->id) }}" class="inline-block text-brand-600 hover:text-brand-800 font-medium text-xs border border-brand-200 hover:bg-brand-50 px-2 py-1 rounded transition">Lihat Detail Kehadiran</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <p class="text-gray-500 text-sm">Belum ada sesi absensi yang dibuat.</p>
            </div>
        @endif
    </div>
</x-sidebar-layout>
