<x-sidebar-layout>
    <x-slot name="header">Kehadiran Guru</x-slot>
    <x-slot name="description">Catat kehadiran harian Anda sebagai staf pengajar.</x-slot>

    <!-- Form Isi Kehadiran -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8 max-w-3xl">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Formulir Kehadiran Hari Ini ({{ \Carbon\Carbon::now()->format('d M Y') }})</h3>
        
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('guru.attendance.self.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status Kehadiran</label>
                    <select name="status" id="status_select" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" required onchange="toggleProofField()">
                        <option value="hadir">Hadir (On-Time)</option>
                        <option value="sakit">Sakit (Dengan Keterangan)</option>
                        <option value="izin">Izin (Dengan Alasan)</option>
                    </select>
                </div>
                <div id="proof_field" class="hidden">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Unggah Surat (PDF/JPG/PNG)</label>
                    <input type="file" name="proof_file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                </div>
            </div>

            <script>
                function toggleProofField() {
                    const status = document.getElementById('status_select').value;
                    const proofField = document.getElementById('proof_field');
                    if (status === 'sakit' || status === 'izin') {
                        proofField.classList.remove('hidden');
                    } else {
                        proofField.classList.add('hidden');
                    }
                }
            </script>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" rows="2" class="w-full rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm" placeholder="Contoh: Terlambat 15 menit karena macet..."></textarea>
            </div>

            <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-lg shadow transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Kirim Laporan Kehadiran
            </button>
        </form>
    </div>

    <!-- Riwayat Kehadiran Pribadi -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 max-w-4xl">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Riwayat Kehadiran Anda Bulan Ini</h3>
        
        @if($attendances->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="p-3 text-sm font-semibold text-gray-600">Tanggal</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Status</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Catatan</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Waktu Lapor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($attendances as $att)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 text-sm text-gray-800 font-medium">{{ \Carbon\Carbon::parse($att->date)->format('l, d M Y') }}</td>
                                <td class="p-3 text-sm">
                                    @if($att->status == 'hadir')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold uppercase">Hadir</span>
                                    @elseif($att->status == 'sakit')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold uppercase">Sakit</span>
                                        @if($att->proof_file_path)
                                            <a href="{{ asset('storage/' . $att->proof_file_path) }}" target="_blank" class="text-[10px] text-blue-600 underline block mt-1">Lihat Surat</a>
                                        @endif
                                    @elseif($att->status == 'izin')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold uppercase">Izin</span>
                                        @if($att->proof_file_path)
                                            <a href="{{ asset('storage/' . $att->proof_file_path) }}" target="_blank" class="text-[10px] text-blue-600 underline block mt-1">Lihat Surat</a>
                                        @endif
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold uppercase">Alpa</span>
                                    @endif
                                </td>
                                <td class="p-3 text-sm text-gray-600">{{ $att->notes ?? '-' }}</td>
                                <td class="p-3 text-xs text-gray-400">{{ $att->created_at->format('H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-6">
                <p class="text-gray-500 text-sm">Belum ada riwayat kehadiran.</p>
            </div>
        @endif
    </div>
</x-sidebar-layout>
