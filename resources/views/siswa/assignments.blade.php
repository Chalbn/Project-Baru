<x-sidebar-layout>
    <x-slot name="header">Tugas & Latihan</x-slot>
    <x-slot name="description">Lihat tugas yang diberikan guru dan unggah jawaban Anda di sini.</x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Daftar Tugas Anda</h3>
        
        @if($assignments->count() > 0)
            <div class="space-y-6">
                @foreach($assignments as $assign)
                    @php
                        $isSubmitted = isset($submissions[$assign->id]);
                    @endphp
                    
                    <div class="border rounded-xl p-5 md:p-6 hover:shadow-md transition bg-gray-50">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-4">
                            <div>
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <h4 class="font-bold text-gray-800 text-lg leading-tight">{{ $assign->title }}</h4>
                                    
                                    @if($isSubmitted)
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Sudah Dikumpulkan
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Belum Dikumpulkan
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-brand-600 font-semibold">{{ $assign->subject->name }} &bull; Guru: {{ $assign->subject->teacher->name }}</p>
                            </div>
                            <div class="bg-white px-3 py-2 rounded-lg border border-gray-200 text-center shrink-0 shadow-sm">
                                <span class="block text-[10px] text-gray-500 font-bold uppercase">Tenggat Waktu</span>
                                <span class="block text-sm font-black text-gray-800">{{ \Carbon\Carbon::parse($assign->due_date)->format('d M Y') }}</span>
                                <span class="block text-xs text-red-500 font-bold">{{ \Carbon\Carbon::parse($assign->due_date)->format('H:i') }} WIB</span>
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg border border-gray-200 mb-4 shadow-inner">
                            <h5 class="text-xs font-bold text-gray-500 uppercase mb-1">Instruksi Guru:</h5>
                            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $assign->description }}</p>
                        </div>
                        
                        @if($isSubmitted)
                            <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-green-800">Berkas Jawaban Tersimpan</p>
                                        <a href="{{ asset('storage/' . $submissions[$assign->id]) }}" target="_blank" class="text-xs text-green-600 hover:underline font-semibold">Buka Berkas &rarr;</a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('siswa.assignments.submit') }}" method="POST" enctype="multipart/form-data" class="mt-4 pt-4 border-t border-gray-200 flex flex-col md:flex-row items-center gap-4">
                                @csrf
                                <input type="hidden" name="assignment_id" value="{{ $assign->id }}">
                                
                                <div class="w-full md:flex-1">
                                    <input type="file" name="file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition" required>
                                </div>
                                <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-lg shadow transition flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Kumpulkan Jawaban
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                <p class="text-gray-500 font-medium">Hore! Belum ada tugas yang diberikan oleh guru.</p>
            </div>
        @endif
    </div>
</x-sidebar-layout>
