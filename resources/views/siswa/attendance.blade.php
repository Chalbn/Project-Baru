<x-sidebar-layout>
    <x-slot name="header">Absensi Siswa</x-slot>
    <x-slot name="description">Catat kehadiran Anda pada sesi pelajaran yang sedang berlangsung.</x-slot>

    <!-- Form Isi Kehadiran (Live Sessions) -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8 max-w-4xl">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
            Sesi Absensi Terbuka (Live)
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
            </span>
        </h3>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif
        
        @if($openSessions->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($openSessions as $session)
                    @php
                        $alreadyAttended = $records->where('attendance_session_id', $session->id)->first();
                        $isExpired = $session->expires_at && now()->greaterThan($session->expires_at);
                    @endphp
                    
                    <div class="border rounded-lg p-5 {{ $alreadyAttended ? 'bg-gray-50 border-gray-200' : 'border-brand-200 bg-brand-50' }}">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $session->subject->name }}</h4>
                                <p class="text-xs text-gray-500">Guru: {{ $session->subject->teacher->name }}</p>
                                @if($session->expires_at)
                                    <p class="text-[10px] mt-1 font-bold {{ $isExpired ? 'text-red-500' : 'text-orange-500' }}">Batas: {{ \Carbon\Carbon::parse($session->expires_at)->format('H:i') }} WIB</p>
                                @endif
                            </div>
                            <span class="text-xs font-bold px-2 py-1 bg-white rounded shadow-sm">{{ \Carbon\Carbon::parse($session->date)->format('d M') }}</span>
                        </div>
                        
                        @if($alreadyAttended)
                            <div class="mt-4 p-3 bg-green-100 text-green-800 rounded-lg text-sm font-bold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Anda sudah mengisi absensi ({{ ucfirst($alreadyAttended->status) }})
                            </div>
                        @elseif($isExpired)
                            <div class="mt-4 p-3 bg-red-100 text-red-800 rounded-lg text-sm font-bold flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Waktu absensi telah habis.
                            </div>
                        @else
                            <form action="{{ route('siswa.attendance.store') }}" method="POST" class="mt-4 flex gap-2">
                                @csrf
                                <input type="hidden" name="session_id" value="{{ $session->id }}">
                                
                                <select name="status" class="flex-1 rounded border-gray-300 text-sm focus:border-brand-500 focus:ring-brand-500" required>
                                    <option value="hadir">Hadir</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="izin">Izin</option>
                                </select>
                                
                                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded text-sm font-bold transition">
                                    Simpan
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-gray-500 text-sm">Tidak ada sesi absensi yang sedang dibuka saat ini.</p>
            </div>
        @endif
    </div>

    <!-- Riwayat Kehadiran -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 max-w-4xl">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Riwayat Kehadiran Anda</h3>
        
        @if($records->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="p-3 text-sm font-semibold text-gray-600">Tanggal</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Mata Pelajaran</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Status</th>
                            <th class="p-3 text-sm font-semibold text-gray-600">Waktu Lapor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($records as $rec)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 text-sm text-gray-800 font-medium">{{ \Carbon\Carbon::parse($rec->session->date)->format('d M Y') }}</td>
                                <td class="p-3 text-sm text-gray-800">{{ $rec->session->subject->name }}</td>
                                <td class="p-3 text-sm">
                                    @if($rec->status == 'hadir')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold uppercase">Hadir</span>
                                    @elseif($rec->status == 'sakit')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold uppercase">Sakit</span>
                                    @elseif($rec->status == 'izin')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold uppercase">Izin</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold uppercase">Alpa</span>
                                    @endif
                                </td>
                                <td class="p-3 text-xs text-gray-400">{{ $rec->created_at->format('H:i') }} WIB</td>
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
