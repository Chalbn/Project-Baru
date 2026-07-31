<x-sidebar-layout>
    <x-slot name="header">Ringkasan Dasbor</x-slot>
    <x-slot name="description">Pantauan metrik utama yayasan hari ini.</x-slot>
    <x-slot name="headerActions">
        <button class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded shadow-sm hover:bg-gray-50 text-sm font-medium transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Unduh Laporan
        </button>
    </x-slot>

    <!-- Panel Atas: KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- KPI 1 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 opacity-10">
                <svg class="w-24 h-24 text-brand-500" fill="currentColor" viewBox="0 0 20 20"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path></svg>
            </div>
            <div class="w-12 h-12 bg-blue-100 text-brand-600 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Pendaftaran Baru</p>
                <h3 class="text-2xl font-bold text-gray-800">124</h3>
                <p class="text-xs text-green-500 font-semibold mt-1">↑ 12% dari bulan lalu</p>
            </div>
        </div>

        <!-- KPI 2 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 relative overflow-hidden">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Siswa Aktif</p>
                <h3 class="text-2xl font-bold text-gray-800">1,450</h3>
                <p class="text-xs text-gray-400 font-semibold mt-1">Statis</p>
            </div>
        </div>

        <!-- KPI 3 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 relative overflow-hidden">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Guru Hadir (Hari Ini)</p>
                <h3 class="text-2xl font-bold text-gray-800">72 / 75</h3>
                <p class="text-xs text-green-500 font-semibold mt-1">96% Kehadiran</p>
            </div>
        </div>

        <!-- KPI 4 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 relative overflow-hidden">
            <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Pendapatan SPP (Bulan Ini)</p>
                <h3 class="text-2xl font-bold text-gray-800">Rp 420M</h3>
                <p class="text-xs text-yellow-600 font-semibold mt-1">↑ 2% dari target</p>
            </div>
        </div>
    </div>

    <!-- Panel Tengah: Pesan & Tugas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Pesan Hari Ini -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Pesan Hari Ini</h3>
            <div class="bg-brand-50 p-4 rounded-lg border border-brand-100 mb-4 relative">
                <svg class="absolute top-4 right-4 w-6 h-6 text-brand-200" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                <p class="text-brand-800 italic relative z-10 leading-relaxed font-serif">"Pendidikan sejati tidak hanya memperkaya pikiran, tetapi juga memurnikan hati. Mari kita layani tunas bangsa dengan integritas tertinggi."</p>
                <p class="text-xs text-brand-600 font-bold mt-2">- Pesan Kepala Yayasan</p>
            </div>
        </div>

        <!-- Tugas Pending -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex justify-between items-center">
                Daftar Tugas Pending
                <span class="bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-xs font-bold">3 Perlu Perhatian</span>
            </h3>
            <ul class="space-y-3">
                <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" class="rounded text-brand-600 focus:ring-brand-500 w-5 h-5 border-gray-300">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Verifikasi 45 pendaftar PPDB baru</p>
                            <p class="text-xs text-gray-500">Batas: Hari ini 15:00</p>
                        </div>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                </li>
                <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" class="rounded text-brand-600 focus:ring-brand-500 w-5 h-5 border-gray-300">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Setujui pengajuan dana BOS triwulan 3</p>
                            <p class="text-xs text-gray-500">Bagian Keuangan</p>
                        </div>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                </li>
                <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" class="rounded text-brand-600 focus:ring-brand-500 w-5 h-5 border-gray-300">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Jadwalkan rapat komite sekolah bulanan</p>
                            <p class="text-xs text-gray-500">Menunggu konfirmasi</p>
                        </div>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Panel Bawah: Berita & Kalender -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Berita Terkini -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="text-lg font-bold text-gray-800">Pembaruan Berita Terkini</h3>
                <a href="#" class="text-sm text-brand-600 font-semibold hover:underline">Kelola Berita</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border rounded-lg overflow-hidden flex flex-col group cursor-pointer hover:shadow-md transition">
                    <div class="h-32 bg-gray-200 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between bg-white">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-yellow-600 mb-1 block">Akademik</span>
                            <h4 class="font-bold text-gray-800 text-sm leading-tight mb-2">Pelepasan Angkatan 2026 Berlangsung Haru</h4>
                        </div>
                        <p class="text-xs text-gray-500">Dipublikasi 2 hari lalu oleh Humas</p>
                    </div>
                </div>
                <div class="border rounded-lg overflow-hidden flex flex-col group cursor-pointer hover:shadow-md transition">
                    <div class="h-32 bg-gray-200 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1560785496-3c9d27877182?auto=format&fit=crop&q=80&w=400" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between bg-white">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-brand-600 mb-1 block">Prestasi</span>
                            <h4 class="font-bold text-gray-800 text-sm leading-tight mb-2">Tim Paduan Suara Masuk Final Nasional</h4>
                        </div>
                        <p class="text-xs text-gray-500">Dipublikasi 5 hari lalu oleh Kesiswaan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kalender Acara -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Acara Mendatang</h3>
            <div class="flex-1 space-y-4">
                <!-- Acara 1 -->
                <div class="flex gap-4 items-start">
                    <div class="flex flex-col items-center justify-center bg-brand-50 border border-brand-100 rounded-lg p-2 min-w-[3.5rem]">
                        <span class="text-xs text-brand-600 font-bold uppercase">Agu</span>
                        <span class="text-lg font-black text-brand-800 leading-none">15</span>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-800 text-sm">Misa Awal Tahun Ajaran</h5>
                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 08:00 - 10:00 WIB</p>
                    </div>
                </div>
                
                <!-- Acara 2 -->
                <div class="flex gap-4 items-start">
                    <div class="flex flex-col items-center justify-center bg-gray-50 border border-gray-200 rounded-lg p-2 min-w-[3.5rem]">
                        <span class="text-xs text-gray-500 font-bold uppercase">Agu</span>
                        <span class="text-lg font-black text-gray-800 leading-none">17</span>
                    </div>
                    <div>
                        <h5 class="font-bold text-gray-800 text-sm">Upacara HUT RI ke-81</h5>
                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 07:30 - Selesai</p>
                    </div>
                </div>
            </div>
            <button class="w-full mt-4 py-2 bg-gray-50 hover:bg-gray-100 text-brand-700 font-semibold text-sm rounded-lg transition border border-gray-200">
                Buka Kalender Penuh
            </button>
        </div>
    </div>
</x-sidebar-layout>
