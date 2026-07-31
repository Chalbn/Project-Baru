<x-sidebar-layout>
    <x-slot name="header">Profil Siswa</x-slot>
    <x-slot name="description">Kelola foto profil dan data pribadi Anda.</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="flex flex-col items-center mb-8">
                <div class="relative group cursor-pointer" x-data="{ photoName: null, photoPreview: null }">
                    <input type="file" name="photo" id="photo" class="hidden" x-ref="photo"
                        x-on:change="
                            photoName = $refs.photo.files[0].name;
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                photoPreview = e.target.result;
                            };
                            reader.readAsDataURL($refs.photo.files[0]);
                        " />
                    
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-200 bg-gray-100 flex items-center justify-center relative shadow-sm" x-on:click="$refs.photo.click()">
                        <!-- Current Profile Photo -->
                        <div x-show="!photoPreview" class="w-full h-full">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl text-gray-400 font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            @endif
                        </div>
                        
                        <!-- New Profile Photo Preview -->
                        <div x-show="photoPreview" class="w-full h-full" style="display: none;">
                            <span class="block w-full h-full bg-cover bg-no-repeat bg-center" x-bind:style="'background-image: url(\'' + photoPreview + '\');'"></span>
                        </div>

                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-white text-xs mt-1 font-semibold">Ubah Foto</span>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-3 text-center">Klik foto untuk mengganti.<br>Maksimal ukuran 2MB (JPG/PNG).</p>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-500 focus:ring-brand-500">
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-brand-500 focus:ring-brand-500">
                    @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Peran Akses (Read-Only)</label>
                    <input type="text" value="{{ Auth::user()->role }}" disabled class="w-full border-gray-200 bg-gray-50 text-gray-500 rounded-lg shadow-sm cursor-not-allowed uppercase">
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-brand-600 text-white font-bold rounded-lg shadow hover:bg-brand-700 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-sidebar-layout>
