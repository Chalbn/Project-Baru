<x-guest-layout>
    @php
        // Determine default tab based on session or validation errors
        $defaultTab = $defaultTab ?? 'login';
        if ($errors->has('name') || $errors->has('role') || session('status') == 'register_failed') {
            $defaultTab = 'register';
        }
    @endphp

    <div x-data="{ tab: '{{ $defaultTab }}' }" class="w-full">
        <!-- Tabs -->
        <div class="flex p-1 bg-gray-100 dark:bg-gray-800 rounded-xl mb-8">
            <button @click="tab = 'login'" 
                    :class="{'bg-white dark:bg-gray-700 shadow-sm text-brand-600 font-bold': tab === 'login', 'text-gray-500 hover:text-gray-700': tab !== 'login'}"
                    class="w-1/2 py-3 px-4 text-center rounded-lg text-sm transition-all duration-300">
                Masuk
            </button>
            <button @click="tab = 'register'" 
                    :class="{'bg-white dark:bg-gray-700 shadow-sm text-brand-600 font-bold': tab === 'register', 'text-gray-500 hover:text-gray-700': tab !== 'register'}"
                    class="w-1/2 py-3 px-4 text-center rounded-lg text-sm transition-all duration-300">
                Daftar Akun
            </button>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Login Form -->
        <div x-show="tab === 'login'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="login_email" :value="__('Email')" />
                    <x-text-input id="login_email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="login_password" :value="__('Password')" />

                    <x-text-input id="login_password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4 flex justify-between items-center">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-brand-600 shadow-sm focus:ring-brand-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat saya') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500" href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all transform hover:-translate-y-0.5">
                        {{ __('Masuk ke Akun') }}
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Register Form -->
        <div x-show="tab === 'register'" x-cloak x-data="{ selectedRole: 'siswa' }" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="register_email" :value="__('Email')" />
                    <x-text-input id="register_email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="register_password" :value="__('Password')" />
                    <x-text-input id="register_password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Role -->
                <div class="mt-4">
                    <x-input-label for="role" :value="__('Mendaftar Sebagai')" />
                    <select id="role" name="role" x-model="selectedRole" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand-500 dark:focus:border-brand-600 focus:ring-brand-500 dark:focus:ring-brand-600 rounded-md shadow-sm block mt-1 w-full" required>
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                        <option value="admin">Admin</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <!-- Mapel (Only for Guru) -->
                <div class="mt-4" x-show="selectedRole === 'guru'" x-transition>
                    <x-input-label for="subject_name" :value="__('Nama Mata Pelajaran yang Diajarkan')" />
                    <x-text-input id="subject_name" class="block mt-1 w-full" type="text" name="subject_name" :value="old('subject_name')" placeholder="Misal: Matematika Wajib" x-bind:required="selectedRole === 'guru'" />
                    <x-input-error :messages="$errors->get('subject_name')" class="mt-2" />
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all transform hover:-translate-y-0.5">
                        {{ __('Daftar Sekarang') }}
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
