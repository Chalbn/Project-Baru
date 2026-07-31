<x-sidebar-layout>
    <x-slot name="header">Konsultasi Siswa</x-slot>
    <x-slot name="description">Pantau dan balas pesan dari siswa terkait program bimbingan atau beasiswa.</x-slot>

    <div class="flex flex-col lg:flex-row gap-6 h-[70vh]">
        <!-- Sidebar Daftar Bimbingan & Siswa -->
        <div class="w-full lg:w-1/3 bg-white border border-gray-100 rounded-xl shadow-sm flex flex-col h-full overflow-hidden">
            <div class="p-4 border-b bg-gray-50">
                <h3 class="font-bold text-gray-800">Program & Siswa</h3>
            </div>
            <div class="flex-1 overflow-y-auto">
                @if($programs->count() > 0)
                    <div class="divide-y">
                        @foreach($programs as $program)
                            <div class="p-4" x-data="{ open: {{ (isset($activeProgram) && $activeProgram->id == $program->id) ? 'true' : 'false' }} }">
                                <button @click="open = !open" class="flex items-center justify-between w-full text-left font-bold text-gray-800 hover:text-brand-600 transition focus:outline-none">
                                    <span>{{ $program->title }}</span>
                                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                
                                <div x-show="open" x-collapse class="mt-2 pl-2 border-l-2 border-brand-100 space-y-1">
                                    @if($program->students->count() > 0)
                                        @foreach($program->students as $student)
                                            <a href="{{ route('guru.consultation.chat', ['program_id' => $program->id, 'student_id' => $student->id]) }}" 
                                               class="block p-2 rounded-lg text-sm transition flex justify-between items-center {{ (isset($activeStudent) && $activeStudent->id == $student->id && $activeProgram->id == $program->id) ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                                                <span>{{ $student->name }}</span>
                                                @if($student->unread_count > 0)
                                                    <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $student->unread_count }}</span>
                                                @endif
                                            </a>
                                        @endforeach
                                    @else
                                        <p class="text-xs text-gray-400 p-2 italic">Belum ada siswa yang bergabung.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-sm text-gray-500 mt-10 px-4">
                        Anda belum membuat program bimbingan apapun.
                    </div>
                @endif
            </div>
        </div>

        <!-- Area Chat -->
        <div class="w-full lg:w-2/3 bg-white border border-gray-100 rounded-xl shadow-sm flex flex-col h-full overflow-hidden relative">
            @if(isset($activeProgram) && isset($activeStudent))
                <!-- Header Chat -->
                <div class="p-4 border-b bg-white flex items-center justify-between z-10 shadow-sm">
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $activeStudent->name }}</h3>
                        <p class="text-xs text-brand-600 font-semibold">{{ $activeProgram->title }}</p>
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
                                                $receiver = $activeStudent;
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
                            <p class="text-sm text-gray-400 italic bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100">Belum ada pesan. Mulai sapa siswa Anda...</p>
                        </div>
                    @endif
                </div>

                <!-- Form Kirim Pesan -->
                <div class="p-3 border-t bg-white">
                    <form action="{{ route('guru.consultation.send', ['program_id' => $activeProgram->id, 'student_id' => $activeStudent->id]) }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="message" class="flex-1 rounded-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 text-sm px-4" placeholder="Ketik balasan Anda..." required autocomplete="off">
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
                    <svg class="w-20 h-20 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Pilih Program & Siswa</h3>
                    <p class="text-gray-500 text-sm max-w-sm">Pilih program dan nama siswa di menu samping untuk melihat riwayat percakapan.</p>
                </div>
            @endif
        </div>
    </div>
</x-sidebar-layout>
