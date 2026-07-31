<x-sidebar-layout>
    <x-slot name="header">Rapor & Nilai Tugas</x-slot>
    <x-slot name="description">Pantau nilai tugas Anda dan rata-rata per mata pelajaran.</x-slot>

    @foreach($subjects as $subject)
        @php
            $submissions = $subject->assignments->flatMap->submissions;
            $gradedSubmissions = $submissions->filter(fn($s) => !is_null($s->score));
            $average = $gradedSubmissions->count() > 0 ? $gradedSubmissions->avg('score') : 0;
        @endphp
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 border-b pb-4 gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Mata Pelajaran: {{ $subject->name }}</h3>
                    <p class="text-sm text-gray-500">Guru: {{ $subject->teacher->name ?? 'Belum ditentukan' }}</p>
                </div>
                <div class="flex flex-col items-center justify-center p-3 rounded-lg {{ $average >= 75 ? 'bg-green-50' : ($average > 0 ? 'bg-yellow-50' : 'bg-gray-50') }}">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Rata-Rata</span>
                    <span class="text-2xl font-bold {{ $average >= 75 ? 'text-green-700' : ($average > 0 ? 'text-yellow-700' : 'text-gray-500') }}">{{ number_format($average, 1) }}</span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-t text-sm font-semibold text-gray-700">
                            <th class="p-3">Judul Tugas</th>
                            <th class="p-3">Status Penilaian</th>
                            <th class="p-3 text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @foreach($subject->assignments as $assignment)
                            @php
                                $sub = $assignment->submissions->first();
                            @endphp
                            <tr class="border-b">
                                <td class="p-3">
                                    <div class="font-semibold text-gray-800">{{ $assignment->title }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Batas Waktu: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="p-3">
                                    @if($sub)
                                        @if(!is_null($sub->score))
                                            <span class="inline-flex items-center gap-1 text-xs font-bold text-green-700 bg-green-100 px-2 py-1 rounded">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Sudah Dinilai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-xs font-bold text-yellow-700 bg-yellow-100 px-2 py-1 rounded">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Menunggu Penilaian
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-red-700 bg-red-100 px-2 py-1 rounded">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Belum Mengumpulkan
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3 text-center">
                                    @if($sub && !is_null($sub->score))
                                        <span class="font-bold text-lg text-gray-800">{{ $sub->score }}</span>
                                    @else
                                        <span class="text-gray-400 font-bold">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        
                        @if($subject->assignments->count() == 0)
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-500 italic">Belum ada tugas di mata pelajaran ini.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
    
    @if($subjects->count() == 0)
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center text-gray-500">
            Anda belum mendaftar di mata pelajaran manapun.
        </div>
    @endif
</x-sidebar-layout>
