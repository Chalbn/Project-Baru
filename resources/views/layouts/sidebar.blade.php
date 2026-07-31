<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} - YPK Santo Yoseph</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800 flex h-screen overflow-hidden">
    @php
        $unreadConsultationsCount = \App\Models\ConsultationMessage::where('receiver_id', Auth::id())->whereNull('read_at')->count();
    @endphp

    <!-- Sidebar -->
    <aside class="w-64 bg-brand-600 text-white flex flex-col h-full flex-shrink-0 shadow-xl z-20 relative transition-all duration-300">
        <div class="h-20 flex items-center justify-center border-b border-brand-500 bg-brand-700">
            <h2 class="text-xl font-bold tracking-wider uppercase">{{ Auth::user()->role }} PANEL</h2>
        </div>
        
        <div class="flex-1 overflow-y-auto py-6 px-4">
            <nav class="space-y-2">
                
                @if(Auth::user()->role === 'admin')
                    <!-- Menu Admin -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dasbor
                    </a>
                @elseif(Auth::user()->role === 'guru')
                    <!-- Menu Guru -->
                    <a href="{{ route('guru.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guru.dashboard') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dasbor
                    </a>
                    <a href="{{ route('guru.attendance') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guru.attendance') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Absensi Siswa
                    </a>
                    <a href="{{ route('guru.attendance.self') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guru.attendance.self') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Absensi Guru
                    </a>
                    <a href="{{ route('guru.assignments') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guru.assignments') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Tugas
                    </a>
                    <a href="{{ route('guru.exams') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guru.exams') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Ujian
                    </a>
                    <a href="{{ route('guru.grades') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guru.grades') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Nilai
                    </a>
                    <a href="{{ route('guru.counseling') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guru.counseling') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Bimbingan
                    </a>
                    <a href="{{ route('guru.consultation') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guru.consultation') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Konsultasi
                        @if($unreadConsultationsCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadConsultationsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('guru.profile') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('guru.profile') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profil
                    </a>
                @elseif(Auth::user()->role === 'siswa')
                    <!-- Menu Siswa -->
                    <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('siswa.dashboard') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dasbor
                    </a>
                    <a href="{{ route('siswa.attendance') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('siswa.attendance') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Absensi
                    </a>
                    <a href="{{ route('siswa.assignments') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('siswa.assignments') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Tugas
                    </a>
                    <a href="{{ route('siswa.exams') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('siswa.exams') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Ujian
                    </a>
                    <a href="{{ route('siswa.grades') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('siswa.grades') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Nilai
                    </a>
                    <a href="{{ route('siswa.counseling') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('siswa.counseling') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Bimbingan
                    </a>
                    <a href="{{ route('siswa.consultation') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('siswa.consultation') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Konsultasi
                        @if($unreadConsultationsCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadConsultationsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('siswa.profile') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('siswa.profile') ? 'bg-brand-700 border-l-4 border-yellow-400' : 'hover:bg-brand-500 border-l-4 border-transparent hover:border-brand-300' }} rounded-lg text-white font-medium transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profil
                    </a>
                @endif
                
            </nav>
        </div>
        
        <div class="p-4 border-t border-brand-500">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 px-4 py-2 hover:bg-brand-700 rounded-lg text-brand-200 font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full overflow-hidden bg-gray-50">
        
        <!-- Header -->
        <header class="h-20 bg-white shadow-sm flex items-center justify-between px-8 z-10 shrink-0 border-b border-gray-200">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo_ypk.png') }}" alt="Logo YPK Santo Yoseph" class="h-12 w-auto">
                <div class="hidden sm:block">
                    <h1 class="text-lg font-bold text-gray-800 leading-tight">YPK Santo Yoseph</h1>
                    <p class="text-xs text-brand-600 font-semibold uppercase">Pematangsiantar</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                </div>
                
                <a href="#" class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold border-2 border-brand-300 overflow-hidden hover:border-yellow-400 transition cursor-pointer">
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                    @else
                        {{ substr(Auth::user()->name, 0, 1) }}
                    @endif
                </a>
            </div>
        </header>

        <!-- Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-8 relative" x-data="{}">
            @if (isset($header))
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $header }}</h2>
                        @if(isset($description))
                            <p class="text-gray-500 text-sm mt-1">{{ $description }}</p>
                        @endif
                    </div>
                    {{ $headerActions ?? '' }}
                </div>
            @endif

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition.duration.500ms class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm flex justify-between items-start">
                    <div>{{ session('success') }}</div>
                    <button @click="show = false" class="text-green-700 hover:text-green-900 focus:outline-none ml-4 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{ $slot }}
            
        </main>
        
        <footer class="bg-white p-4 border-t border-gray-200 text-center text-xs text-gray-500 shrink-0 mt-auto">
            &copy; 2026 Sistem Manajemen Sekolah Terpadu - YPK Santo Yoseph Pematangsiantar
        </footer>
    </div>
    
</body>
</html>
