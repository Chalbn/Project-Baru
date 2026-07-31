<x-sidebar-layout>
    <x-slot name="header">Nilai Tugas Siswa</x-slot>
    <x-slot name="description">Rekapitulasi nilai tugas siswa beserta rata-ratanya.</x-slot>

    @foreach($subjects as $subject)
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Mata Pelajaran: {{ $subject->name }} (Kelas {{ $subject->grade_level }})</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-t text-sm font-semibold text-gray-700">
                            <th class="p-3">Nama Siswa</th>
                            <th class="p-3">Detail Nilai Tugas</th>
                            <th class="p-3 text-center">Rata-Rata</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @foreach($subject->students as $student)
                            @php
                                // Get all submissions for this student in this subject
                                $studentSubmissions = collect();
                                foreach($subject->assignments as $assignment) {
                                    $sub = $assignment->submissions->where('student_id', $student->id)->first();
                                    if($sub) {
                                        $studentSubmissions->push($sub);
                                    }
                                }
                                $gradedSubmissions = $studentSubmissions->filter(fn($s) => !is_null($s->score));
                                $average = $gradedSubmissions->count() > 0 ? $gradedSubmissions->avg('score') : 0;
                            @endphp
                            <tr class="border-b">
                                <td class="p-3 font-semibold">{{ $student->name }}</td>
                                <td class="p-3">
                                    @if($studentSubmissions->count() > 0)
                                        <div class="space-y-2">
                                            @foreach($studentSubmissions as $sub)
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs font-medium text-gray-600 w-48 truncate" title="{{ $sub->assignment->title }}">{{ $sub->assignment->title }}</span>
                                                    <form action="{{ route('guru.grades.update') }}" method="POST" class="flex items-center gap-1">
                                                        @csrf
                                                        <input type="hidden" name="submission_id" value="{{ $sub->id }}">
                                                        <input type="number" name="score" value="{{ $sub->score }}" min="0" max="100" class="w-16 h-7 text-xs rounded border-gray-300 focus:border-brand-500 focus:ring-brand-500 p-1 text-center" placeholder="-">
                                                        <button type="submit" class="text-[10px] bg-brand-100 text-brand-700 hover:bg-brand-200 px-2 py-1 rounded font-bold uppercase tracking-wider transition">Ralat</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Belum mengumpulkan tugas satupun.</span>
                                    @endif
                                </td>
                                <td class="p-3 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-sm font-bold {{ $average >= 75 ? 'bg-green-100 text-green-700' : ($average > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500') }}">
                                        {{ number_format($average, 1) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        
                        @if($subject->students->count() == 0)
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-500 italic">Belum ada siswa yang mendaftar di mata pelajaran ini.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
    
    @if($subjects->count() == 0)
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center text-gray-500">
            Anda belum ditugaskan pada mata pelajaran manapun.
        </div>
    @endif
</x-sidebar-layout>
