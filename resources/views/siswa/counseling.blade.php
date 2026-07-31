<x-sidebar-layout>
    <x-slot name="header">Bimbingan Lomba & Beasiswa</x-slot>
    <x-slot name="description">Ikuti program bimbingan lomba dan dapatkan informasi beasiswa dari guru.</x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Program Bimbingan Tersedia</h3>
        @if(isset($programs) && $programs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($programs as $prog)
                    <div class="border rounded-lg p-5 hover:shadow-md transition bg-white flex flex-col justify-between">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-brand-600 mb-2 inline-block px-2 py-1 bg-brand-50 rounded">{{ $prog->type }}</span>
                            <h4 class="font-bold text-gray-800 text-lg mb-1">{{ $prog->title }}</h4>
                            <p class="text-xs text-gray-500 mb-3">Guru Pembimbing: {{ $prog->teacher->name ?? 'Tidak diketahui' }}</p>
                            <p class="text-sm text-gray-700 mb-4 line-clamp-3">{{ $prog->description }}</p>
                        </div>
                        @if($prog->students->contains(auth()->id()))
                            <button disabled class="w-full py-2 bg-green-500 text-white text-sm font-bold rounded shadow cursor-not-allowed">Terdaftar</button>
                        @else
                            <form action="{{ route('siswa.counseling.register', $prog->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2 bg-brand-600 text-white text-sm font-bold rounded shadow hover:bg-brand-700 transition">Daftar Program</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <p class="text-gray-500 text-sm">Belum ada program bimbingan yang dibuka oleh guru.</p>
            </div>
        @endif
    </div>
</x-sidebar-layout>
