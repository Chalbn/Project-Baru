<x-sidebar-layout>
    <x-slot name="header">Detail Absensi: {{ $session->subject->name }}</x-slot>
    <x-slot name="description">Laporan kehadiran untuk tanggal {{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}.</x-slot>

    <div class="mb-6">
        <a href="{{ route('guru.attendance') }}" class="text-brand-600 hover:text-brand-800 font-semibold text-sm flex items-center gap-1 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Absensi
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Rekapitulasi Siswa</h3>
                <p class="text-sm text-gray-500">Total Siswa Terdaftar: {{ $session->subject->students->count() }}</p>
            </div>
            
            <div class="flex gap-2 text-sm font-bold">
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded">{{ $session->records->where('status', 'hadir')->count() }} Hadir</span>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded">{{ $session->records->where('status', 'sakit')->count() }} Sakit</span>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded">{{ $session->records->where('status', 'izin')->count() }} Izin</span>
            </div>
        </div>

        @if($session->subject->students->count() > 0)
            <form action="{{ route('guru.attendance.update_records', $session->id) }}" method="POST">
                @csrf
                <div class="overflow-x-auto mb-6">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="p-3 text-sm font-semibold text-gray-600 w-1/3">Nama Siswa</th>
                                <th class="p-3 text-sm font-semibold text-gray-600">Status Kehadiran (Ubah)</th>
                                <th class="p-3 text-sm font-semibold text-gray-600 w-1/4">Waktu Lapor</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($session->subject->students as $student)
                                @php
                                    $record = $session->records->where('student_id', $student->id)->first();
                                    $currentStatus = $record ? $record->status : 'alpa';
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200 shrink-0">
                                                @if($student->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $student->profile_photo_path) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-500 font-bold text-xs">{{ substr($student->name, 0, 1) }}</div>
                                                @endif
                                            </div>
                                            <span class="text-sm font-bold text-gray-800">{{ $student->name }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3 text-sm">
                                        <select name="attendance[{{ $student->id }}]" class="rounded-lg border-gray-300 focus:border-brand-500 focus:ring-brand-500 shadow-sm text-sm">
                                            <option value="hadir" {{ $currentStatus == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                            <option value="sakit" {{ $currentStatus == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                            <option value="izin" {{ $currentStatus == 'izin' ? 'selected' : '' }}>Izin</option>
                                            <option value="alpa" {{ $currentStatus == 'alpa' ? 'selected' : '' }}>Alpa / Belum Absen</option>
                                        </select>
                                    </td>
                                    <td class="p-3 text-sm text-gray-500">
                                        @if($record)
                                            <span class="flex items-center gap-1 text-green-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                {{ $record->created_at->format('H:i:s WIB') }}
                                            </span>
                                        @else
                                            <span class="text-red-500">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-lg shadow transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Perubahan Absensi
                    </button>
                </div>
            </form>
        @else
            <div class="text-center py-6">
                <p class="text-gray-500 text-sm">Belum ada siswa yang mendaftar ke kelas ini.</p>
            </div>
        @endif
    </div>
</x-sidebar-layout>
