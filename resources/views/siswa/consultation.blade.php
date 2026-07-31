<x-sidebar-layout>
    <x-slot name="header">Konsultasi Bimbingan</x-slot>
    <x-slot name="description">Diskusikan perkembangan belajar atau program beasiswa dengan guru pembimbing Anda.</x-slot>

    <div class="flex flex-col lg:flex-row gap-6 h-[70vh]">
        <!-- Sidebar Daftar Bimbingan -->
        <div class="w-full lg:w-1/3 bg-white border border-gray-100 rounded-xl shadow-sm flex flex-col h-full overflow-hidden">
            <div class="p-4 border-b bg-gray-50">
                <h3 class="font-bold text-gray-800">Program Bimbingan Saya</h3>
            </div>
            <div class="flex-1 overflow-y-auto p-2">
                @if($programs->count() > 0)
                    <ul class="space-y-1">
                        @foreach($programs as $program)
                            <li>
                                <a href="{{ route('siswa.consultation.show', $program->id) }}" class="block p-3 rounded-lg transition {{ (isset($activeProgram) && $activeProgram->id == $program->id) ? 'bg-brand-50 border border-brand-100' : 'hover:bg-gray-50 border border-transparent' }}">
                                    <div class="font-semibold text-sm {{ (isset($activeProgram) && $activeProgram->id == $program->id) ? 'text-brand-700' : 'text-gray-800' }}">
                                        {{ $program->title }}
                                        @if($program->unread_count > 0)
                                            <span class="ml-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $program->unread_count }}</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1 flex items-center justify-between">
                                        <span>Guru: {{ $program->teacher->name }}</span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center text-sm text-gray-500 mt-10">
                        Anda belum mendaftar di program bimbingan manapun.
                    </div>
                @endif
            </div>
        </div>

        <!-- Area Chat -->
        <div class="w-full lg:w-2/3 bg-white border border-gray-100 rounded-xl shadow-sm flex flex-col h-full overflow-hidden relative">
            @if(isset($activeProgram))
                <!-- Header Chat -->
                <div class="p-4 border-b bg-white flex items-center justify-between z-10 shadow-sm">
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $activeProgram->title }}</h3>
                        <p class="text-xs text-gray-500">Konsultasi dengan {{ $activeProgram->teacher->name }}</p>
                    </div>
                </div>

                <!-- Pesan Chat -->
                <div class="flex-1 overflow-y-auto p-5 bg-gray-50 space-y-4 flex flex-col" id="chatContainer">
                    @if($messages->count() > 0)
                        @foreach($messages as $msg)
                            @php
                                $isMe = $msg->sender_id === auth()->id();
                            @endphp
                            <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[75%] rounded-xl px-4 py-2 shadow-sm {{ $isMe ? 'bg-brand-500 text-white rounded-br-none' : 'bg-white border border-gray-100 text-gray-800 rounded-bl-none' }}">
                                    <p class="text-sm break-words">{{ $msg->message }}</p>
                                    <div class="text-[10px] mt-1 text-right flex items-center justify-end gap-1 {{ $isMe ? 'text-brand-100' : 'text-gray-400' }}">
                                        {{ $msg->created_at->format('H:i') }}
                                        @if($isMe)
                                            @php
                                                $receiver = $activeProgram->teacher;
                                                $isOnline = $receiver->last_seen_at && $receiver->last_seen_at->diffInMinutes(now()) <= 5;
                                            @endphp
                                            @if($msg->read_at)
                                                <!-- Centang 2 Biru/Terang (Dibaca) -->
                                                <div class="flex items-center ml-1">
                                                    <svg class="w-3 h-3 text-blue-300 -mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    <svg class="w-3 h-3 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                            @elseif($isOnline)
                                                <!-- Centang 2 Abu (Terkirim, Online) -->
                                                <div class="flex items-center ml-1 opacity-70">
                                                    <svg class="w-3 h-3 text-gray-300 -mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                            @else
                                                <!-- Centang 1 Abu (Terkirim, Offline) -->
                                                <svg class="w-3 h-3 text-gray-300 ml-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex-1 flex items-center justify-center">
                            <p class="text-sm text-gray-400 italic bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100">Mulai percakapan dengan guru Anda...</p>
                        </div>
                    @endif
                </div>

                <!-- Form Kirim Pesan -->
                <div class="p-3 border-t bg-white">
                    <form action="{{ route('siswa.consultation.send', $activeProgram->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="message" class="flex-1 rounded-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 text-sm px-4" placeholder="Ketik pesan konsultasi..." required autocomplete="off">
                        <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white rounded-full w-10 h-10 flex items-center justify-center shadow-sm transition shrink-0">
                            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>
                
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const chatContainer = document.getElementById("chatContainer");
                        if(chatContainer) {
                            chatContainer.scrollTop = chatContainer.scrollHeight;
                        }
                    });
                </script>
            @else
                <div class="flex-1 flex flex-col items-center justify-center text-center p-6">
                    <svg class="w-20 h-20 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Pilih Program Bimbingan</h3>
                    <p class="text-gray-500 text-sm max-w-sm">Silakan pilih program bimbingan di sebelah kiri untuk mulai berkonsultasi dengan guru pembimbing.</p>
                </div>
            @endif
        </div>
    </div>
</x-sidebar-layout>
