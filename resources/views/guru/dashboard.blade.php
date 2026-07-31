<x-sidebar-layout>
    <x-slot name="header">Dasbor Guru</x-slot>
    <x-slot name="description">Selamat datang kembali, {{ Auth::user()->name }}.</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 relative overflow-hidden hover:shadow-md transition">
            <div class="w-12 h-12 bg-blue-100 text-brand-600 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Mata Pelajaran Anda</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $subjects->count() }}</h3>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Daftar Siswa Terdaftar (KRS)</h3>
        
        @if($subjects->count() > 0)
            <div class="space-y-6">
                @foreach($subjects as $subject)
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                            <h4 class="font-bold text-brand-700">{{ $subject->name }} <span class="text-xs font-normal text-gray-500 ml-1">Kelas {{ $subject->grade_level }}</span></h4>
                            <span class="bg-brand-100 text-brand-700 text-xs font-bold px-2 py-1 rounded">{{ $subject->students->count() }} Siswa</span>
                        </div>
                        <div class="p-4">
                            @if($subject->students->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach($subject->students as $student)
                                        <div class="flex items-center gap-3 p-2 border rounded hover:bg-gray-50">
                                            <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-200 shrink-0">
                                                @if($student->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $student->profile_photo_path) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-500 font-bold text-xs">{{ substr($student->name, 0, 1) }}</div>
                                                @endif
                                            </div>
                                            <div class="overflow-hidden">
                                                <p class="text-sm font-bold text-gray-800 truncate">{{ $student->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $student->email }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 text-center py-2">Belum ada siswa yang mendaftar di mata pelajaran ini.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500 text-sm">Anda belum ditugaskan untuk mengajar mata pelajaran apapun.</p>
            </div>
        @endif
    </div>
</x-sidebar-layout>
