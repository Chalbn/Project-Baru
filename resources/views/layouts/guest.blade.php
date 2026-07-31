<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Portal Akademik YPK Santo Yoseph') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Inter', sans-serif; }
            .bg-hero-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 selection:bg-brand-500 selection:text-white overflow-x-hidden">
        <div class="min-h-screen flex flex-col md:flex-row">
            
            <!-- Left Side: Branding & Visuals (Hidden on small screens) -->
            <div class="hidden md:flex md:w-5/12 lg:w-1/2 bg-gradient-to-br from-brand-600 via-brand-500 to-sky-400 relative items-center justify-center overflow-hidden">
                <div class="absolute inset-0 bg-hero-pattern opacity-50"></div>
                
                <!-- Decorative Circle -->
                <div class="absolute top-1/4 -left-20 w-72 h-72 bg-brand-400 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-pulse"></div>
                <div class="absolute bottom-1/4 -right-20 w-80 h-80 bg-yellow-400 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-pulse" style="animation-delay: 2s;"></div>

                <div class="relative z-10 p-12 text-center text-white flex flex-col items-center">
                    <div class="w-32 h-32 bg-white rounded-full p-2 shadow-2xl mb-8 flex items-center justify-center transform hover:scale-105 transition duration-500">
                        <img src="{{ asset('storage/logo.png') }}" alt="Logo YPK Santo Yoseph" class="w-24 h-24 object-contain" onerror="this.src='https://ui-avatars.com/api/?name=YPK+SY&background=0ea5e9&color=fff&size=100&rounded=true'; this.onerror=null;">
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight mb-4 drop-shadow-md">YPK. SANTO YOSEPH</h1>
                    <p class="text-xl font-medium text-brand-50 mb-8 tracking-wide drop-shadow">PEMATANGSIANTAR</p>
                    <div class="h-1 w-24 bg-yellow-400 rounded-full mb-8 shadow-[0_0_10px_rgba(250,204,21,0.8)]"></div>
                    <p class="text-base text-brand-100 max-w-sm leading-relaxed">
                        Portal Akademik Digital. Membangun karakter, mengukir prestasi, dan melayani dengan kasih.
                    </p>
                </div>
            </div>

            <!-- Right Side: Forms -->
            <div class="flex-1 flex items-center justify-center p-6 sm:p-12 bg-white relative">
                <!-- Mobile Logo (Visible only on small screens) -->
                <div class="absolute top-8 left-0 right-0 flex justify-center md:hidden">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-10 h-10" onerror="this.src='https://ui-avatars.com/api/?name=SY&background=0ea5e9&color=fff';">
                        <span class="font-bold text-brand-700 text-xl tracking-tight">YPK. SANTO YOSEPH</span>
                    </div>
                </div>

                <div class="w-full max-w-md mt-16 md:mt-0">
                    <div class="mb-10">
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selamat Datang! 👋</h2>
                        <p class="text-sm text-gray-500 mt-2">Silakan masuk ke akun Anda atau daftar jika belum memiliki akun.</p>
                    </div>

                    <div class="bg-white">
                        {{ $slot }}
                    </div>
                </div>
            </div>
            
        </div>
    </body>
</html>
