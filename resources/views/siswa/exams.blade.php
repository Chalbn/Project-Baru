<x-sidebar-layout>
    <x-slot name="header">Ujian Online (CBT)</x-slot>
    <x-slot name="description">Kerjakan ujian dan penilaian dari guru secara langsung di sini.</x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Jadwal Ujian Anda</h3>
        
        @if($exams->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($exams as $exam)
                    <div class="border border-brand-200 rounded-xl overflow-hidden hover:shadow-lg transition">
                        <div class="bg-brand-50 p-4 border-b border-brand-100 flex justify-between items-center">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-brand-600 block mb-1">Ujian Tersedia</span>
                                <h4 class="font-bold text-brand-900">{{ $exam->title }}</h4>
                            </div>
                            <div class="bg-white px-3 py-1 rounded shadow-sm text-center border border-brand-100">
                                <span class="block text-[10px] font-bold text-gray-500 uppercase">Durasi</span>
                                <span class="block text-sm font-black text-brand-600">{{ $exam->duration_minutes }} Mnt</span>
                            </div>
                        </div>
                        <div class="p-4 bg-white">
                            <p class="text-xs text-gray-500 mb-4">{{ $exam->description ?? 'Tidak ada instruksi khusus.' }}</p>
                            
                            <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                <span class="text-xs font-bold text-gray-600">{{ $exam->subject->name }} - Guru: {{ $exam->subject->teacher->name }}</span>
                                <button class="px-4 py-2 bg-brand-600 text-white text-sm font-bold rounded shadow hover:bg-brand-700 transition">Mulai Ujian</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <p class="text-gray-500 font-medium">Belum ada jadwal ujian online saat ini.</p>
            </div>
        @endif
    </div>
</x-sidebar-layout>
