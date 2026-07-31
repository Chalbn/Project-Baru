<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YPK Santo Yoseph Pematangsiantar</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo_ypk.png') }}" alt="Logo YPK Santo Yoseph" class="h-14 w-auto drop-shadow-sm">
                    <div>
                        <h1 class="text-xl font-bold text-brand-900 leading-tight">YPK Santo Yoseph</h1>
                        <p class="text-xs text-brand-600 font-semibold tracking-wider">PEMATANGSIANTAR</p>
                    </div>
                </div>
                <nav class="hidden md:flex gap-8 items-center font-medium text-gray-600">
                    <a href="#" class="hover:text-brand-600 transition">Beranda</a>
                    <a href="#" class="hover:text-brand-600 transition">Profil</a>
                    <a href="#" class="hover:text-brand-600 transition">Akademik</a>
                    <a href="#" class="hover:text-brand-600 transition">Berita</a>
                    <a href="#" class="hover:text-brand-600 transition">Galeri</a>
                    <a href="#" class="hover:text-brand-600 transition">Kontak</a>
                </nav>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-brand-600 transition focus:outline focus:outline-2 focus:rounded-sm focus:outline-brand-500">Dasbor</a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-lg text-brand-700 bg-brand-50 hover:bg-brand-100 font-semibold transition border border-brand-200">Masuk</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Banner -->
    <section class="relative bg-brand-900 h-[600px] flex items-center justify-center">
        <!-- Hero Background -->
        <div class="absolute inset-0 w-full h-full">
            <img src="{{ asset('images/hero_banner.png') }}" alt="Siswa belajar" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-900 via-brand-900/60 to-transparent"></div>
        </div>
        
        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
            <h2 class="text-4xl md:text-6xl font-bold text-white mb-6 font-serif leading-tight drop-shadow-lg">YPK Santo Yoseph: Membentuk Masa Depan</h2>
            <p class="text-lg md:text-xl text-brand-100 mb-10 max-w-2xl mx-auto">Mendidik dengan kasih, disiplin, dan keunggulan akademik untuk menghasilkan generasi pemimpin berkarakter.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-yellow-500 hover:bg-yellow-400 text-brand-900 font-bold rounded-full transition shadow-lg text-lg">Gabung Sekarang</a>
                <a href="#" class="px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-bold rounded-full transition border border-white/30 backdrop-blur-sm text-lg">Jelajahi Program</a>
            </div>
        </div>
    </section>

    <!-- Fitur Utama -->
    <section class="py-16 -mt-20 relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Unit Pendidikan -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-brand-500 transform transition hover:-translate-y-1">
                    <div class="p-8">
                        <div class="w-14 h-14 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Unit Pendidikan Lengkap</h3>
                        <p class="text-gray-600 mb-6">Mulai dari fondasi usia dini hingga kejuruan profesional, kami menyediakan pendidikan berkesinambungan.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 font-semibold rounded text-sm">TK</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 font-semibold rounded text-sm">SD</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 font-semibold rounded text-sm">SMP</span>
                            <span class="px-3 py-1 bg-brand-100 text-brand-700 font-bold rounded text-sm shadow-sm">SMA</span>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 font-semibold rounded text-sm">SMK</span>
                        </div>
                    </div>
                </div>

                <!-- Nilai Katolik -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-yellow-500 transform transition hover:-translate-y-1">
                    <div class="p-8">
                        <div class="w-14 h-14 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Nilai-Nilai Katolik</h3>
                        <p class="text-gray-600 mb-6">Berakar kuat pada ajaran gereja, menekankan cinta kasih, kedisiplinan, integritas, dan solidaritas sosial bagi semua siswa.</p>
                        <a href="#" class="text-brand-600 font-semibold hover:text-brand-800 flex items-center gap-1">Pelajari lebih lanjut <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                    </div>
                </div>

                <!-- Prestasi -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-brand-500 transform transition hover:-translate-y-1">
                    <div class="p-8">
                        <div class="w-14 h-14 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Pusat Prestasi</h3>
                        <p class="text-gray-600 mb-6">Kami mencetak lulusan berprestasi secara akademis dan non-akademis, siap bersaing di tingkat nasional maupun internasional.</p>
                        <a href="#" class="text-brand-600 font-semibold hover:text-brand-800 flex items-center gap-1">Lihat Hall of Fame <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Grid Berita & Aktivitas -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 font-serif">Aktivitas & Berita Kampus</h2>
                    <p class="text-gray-500 mt-2">Dapatkan informasi terbaru seputar kegiatan akademik dan non-akademik.</p>
                </div>
                <a href="#" class="hidden md:inline-flex px-4 py-2 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">Lihat Semua</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Feature -->
                <div class="lg:col-span-2 group cursor-pointer relative overflow-hidden rounded-2xl shadow-md h-[400px]">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80&w=1200" alt="Wisuda" class="w-full h-full object-cover transform transition duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-8">
                        <span class="px-3 py-1 bg-yellow-500 text-brand-900 font-bold text-xs rounded uppercase tracking-wider mb-3 inline-block">Sorotan Utama</span>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-2 leading-tight">Pelepasan Siswa SMA & SMK Angkatan 2026 yang Spektakuler</h3>
                        <p class="text-gray-200 line-clamp-2">Upacara kelulusan tahun ini dimeriahkan dengan pagelaran seni tradisional dan sambutan inspiratif dari Uskup Agung.</p>
                    </div>
                </div>

                <!-- Side Feed -->
                <div class="flex flex-col gap-6">
                    <!-- Card 1 -->
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex gap-4 cursor-pointer hover:shadow-md transition">
                        <div class="w-24 h-24 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=300" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="text-xs font-semibold text-brand-600 mb-1">Berita Akademik</span>
                            <h4 class="font-bold text-gray-800 line-clamp-2 mb-1">Penerimaan Peserta Didik Baru (PPDB) Telah Dibuka!</h4>
                            <span class="text-xs text-gray-500">28 Juli 2026</span>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex gap-4 cursor-pointer hover:shadow-md transition">
                        <div class="w-24 h-24 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1560785496-3c9d27877182?auto=format&fit=crop&q=80&w=300" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="text-xs font-semibold text-brand-600 mb-1">Kegiatan Ekstra</span>
                            <h4 class="font-bold text-gray-800 line-clamp-2 mb-1">Tim Paduan Suara YPK Raih Juara 1 Nasional</h4>
                            <span class="text-xs text-gray-500">20 Juli 2026</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex gap-4 cursor-pointer hover:shadow-md transition">
                        <div class="w-24 h-24 rounded-lg bg-brand-100 flex-shrink-0 flex flex-col items-center justify-center text-brand-700">
                            <span class="text-2xl font-bold">15</span>
                            <span class="text-xs font-semibold uppercase">Agustus</span>
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="text-xs font-semibold text-yellow-600 mb-1">Kalender Acara</span>
                            <h4 class="font-bold text-gray-800 line-clamp-2 mb-1">Misa Awal Tahun Ajaran Bersama</h4>
                            <span class="text-xs text-gray-500">Kapel Santo Yoseph, 08:00 WIB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-950 text-gray-300 py-16 border-t-4 border-yellow-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-white rounded-lg inline-block">
                        <img src="{{ asset('images/logo_ypk.png') }}" alt="Logo" class="h-10 w-auto">
                    </div>
                    <h2 class="text-2xl font-bold text-white">YPK Santo Yoseph</h2>
                </div>
                <p class="text-brand-200 mb-6 max-w-md leading-relaxed">Pusat pendidikan terdepan di Pematangsiantar yang memadukan keunggulan akademik dengan nilai-nilai luhur moral Katolik, mendidik untuk membentuk masa depan bangsa.</p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-brand-900 flex items-center justify-center hover:bg-brand-700 hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-brand-900 flex items-center justify-center hover:bg-brand-700 hover:text-white transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                </div>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-6 tracking-wide">Tautan Cepat</h4>
                <ul class="space-y-3 text-brand-300">
                    <li><a href="#" class="hover:text-yellow-500 transition">Tentang Yayasan</a></li>
                    <li><a href="#" class="hover:text-yellow-500 transition">Info Pendaftaran (PPDB)</a></li>
                    <li><a href="#" class="hover:text-yellow-500 transition">Fasilitas Sekolah</a></li>
                    <li><a href="#" class="hover:text-yellow-500 transition">Berita & Pengumuman</a></li>
                    <li><a href="#" class="hover:text-yellow-500 transition">Karir & Lowongan</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-white font-bold mb-6 tracking-wide">Hubungi Kami</h4>
                <ul class="space-y-4 text-brand-300">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Jl. Viyata Yudha No. 1<br>Pematangsiantar, Sumatera Utara</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>info@ypksantoyoseph.sch.id</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>(0622) 123456</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-16 pt-8 border-t border-brand-800 text-center text-sm text-brand-400">
            <p>&copy; 2026 Yayasan Pendidikan Katolik Santo Yoseph Pematangsiantar. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>
