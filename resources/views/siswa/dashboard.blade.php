<x-sidebar-layout>
    <x-slot name="header">Dasbor Siswa</x-slot>
    <x-slot name="description">Selamat datang di portal akademik digital, {{ Auth::user()->name }}.</x-slot>

    <!-- Mata Pelajaran yang Diambil -->
    <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Mata Pelajaran Anda (KRS)</h3>
        
        @if($enrolledSubjects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($enrolledSubjects as $subject)
                    <div class="bg-white rounded-xl shadow-sm border border-brand-200 p-6 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="w-10 h-10 bg-brand-100 text-brand-600 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-1">{{ $subject->name }}</h4>
                            <p class="text-xs font-semibold text-brand-600 bg-brand-50 inline-block px-2 py-1 rounded">Kelas {{ $subject->grade_level }}</p>
                            <p class="text-sm text-gray-500 mt-3">Guru: {{ $subject->teacher->name }}</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-xs text-green-600 font-bold uppercase flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Terdaftar
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded shadow-sm text-yellow-800 flex items-start gap-3">
                <svg class="w-6 h-6 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div>
                    <h4 class="font-bold">Perhatian!</h4>
                    <p class="text-sm">Anda belum mendaftar di mata pelajaran apapun. Silakan ambil mata pelajaran dari daftar di bawah ini agar Anda dapat mengisi absensi dan mengerjakan tugas.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Pendaftaran Mata Pelajaran Baru -->
    <div>
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Mata Pelajaran yang Tersedia</h3>
        
        @if($availableSubjects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($availableSubjects as $subject)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex justify-between items-center hover:border-brand-300 transition">
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $subject->name }} <span class="text-xs font-normal text-gray-500">(Kelas {{ $subject->grade_level }})</span></h4>
                            <p class="text-sm text-gray-500 mt-1">Diajar oleh: {{ $subject->teacher->name }}</p>
                        </div>
                        <form action="{{ route('siswa.enroll') }}" method="POST">
                            @csrf
                            <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                            <button type="submit" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold rounded shadow transition">
                                Ambil Mapel
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 bg-gray-50 rounded-xl border border-gray-200">
                <p class="text-gray-500 text-sm">Tidak ada mata pelajaran baru yang tersedia untuk diambil.</p>
            </div>
        @endif
    </div>
</x-sidebar-layout>
