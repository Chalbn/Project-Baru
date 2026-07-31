<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AttendanceSession;
use App\Models\AttendanceRecord;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Exam;
use App\Models\CounselingProgram;
use App\Models\ConsultationMessage;

class StudentController extends Controller
{
    public function dashboard()
    {
        $enrolledSubjects = auth()->user()->enrolledSubjects;
        $enrolledSubjectIds = $enrolledSubjects->pluck('id');
        
        $availableSubjects = \App\Models\Subject::whereNotIn('id', $enrolledSubjectIds)->with('teacher')->get();
        
        return view('siswa.dashboard', compact('enrolledSubjects', 'availableSubjects'));
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
        ]);

        auth()->user()->enrolledSubjects()->syncWithoutDetaching([$request->subject_id]);

        return back()->with('success', 'Berhasil mengambil mata pelajaran!');
    }

    // Absensi
    public function attendance()
    {
        \Illuminate\Support\Facades\Artisan::call('app:close-expired-attendance');

        $subjects = auth()->user()->enrolledSubjects;
        $subjectIds = $subjects->pluck('id');
        $openSessions = AttendanceSession::whereIn('subject_id', $subjectIds)->where('is_open', true)->orderBy('created_at', 'desc')->get();
        $records = AttendanceRecord::where('student_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('siswa.attendance', compact('openSessions', 'records'));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:attendance_sessions,id',
            'status' => 'required|in:hadir,izin,sakit',
        ]);

        $session = AttendanceSession::findOrFail($request->session_id);

        if (!$session->is_open) {
            return back()->withErrors(['message' => 'Sesi absensi sudah ditutup oleh guru.']);
        }

        if ($session->expires_at && now()->greaterThan($session->expires_at)) {
            return back()->withErrors(['message' => 'Batas waktu absensi telah kedaluwarsa (' . \Carbon\Carbon::parse($session->expires_at)->format('H:i') . ' WIB).']);
        }

        AttendanceRecord::updateOrCreate(
            ['attendance_session_id' => $session->id, 'student_id' => auth()->id()],
            ['status' => $request->status]
        );

        return back()->with('success', 'Kehadiran berhasil dicatat!');
    }

    // Tugas
    public function assignments()
    {
        $subjects = auth()->user()->enrolledSubjects;
        $subjectIds = $subjects->pluck('id');
        $assignments = Assignment::whereIn('subject_id', $subjectIds)->orderBy('created_at', 'desc')->get();
        $submissions = AssignmentSubmission::where('student_id', auth()->id())->pluck('file_path', 'assignment_id');
        return view('siswa.assignments', compact('assignments', 'submissions'));
    }

    public function submitAssignment(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'file' => 'required|file|max:5120', // 5MB max
        ]);

        $path = $request->file('file')->store('assignments', 'public');

        AssignmentSubmission::updateOrCreate(
            ['assignment_id' => $request->assignment_id, 'student_id' => auth()->id()],
            ['file_path' => $path]
        );

        return back()->with('success', 'Tugas berhasil diunggah!');
    }

    // Ujian
    public function exams()
    {
        $subjects = auth()->user()->enrolledSubjects;
        $subjectIds = $subjects->pluck('id');
        $exams = Exam::whereIn('subject_id', $subjectIds)->orderBy('created_at', 'desc')->get();
        return view('siswa.exams', compact('exams'));
    }

    // Nilai
    public function grades()
    {
        $subjects = auth()->user()->enrolledSubjects()->with(['assignments' => function($q) {
            $q->with(['submissions' => function($q2) {
                $q2->where('student_id', auth()->id());
            }]);
        }])->get();
        
        return view('siswa.grades', compact('subjects'));
    }

    // Bimbingan
    public function counseling()
    {
        $programs = CounselingProgram::with('teacher', 'students')->orderBy('created_at', 'desc')->get();
        return view('siswa.counseling', compact('programs'));
    }

    public function registerCounseling(Request $request, $id)
    {
        $program = CounselingProgram::findOrFail($id);
        $program->students()->syncWithoutDetaching([auth()->id()]);
        return back()->with('success', 'Berhasil mendaftar ke program bimbingan!');
    }

    // Konsultasi
    public function consultation()
    {
        $programs = auth()->user()->counselingPrograms()->with('teacher')->get();
        foreach ($programs as $program) {
            $program->unread_count = \App\Models\ConsultationMessage::where('counseling_program_id', $program->id)
                ->where('receiver_id', auth()->id())
                ->whereNull('read_at')
                ->count();
        }
        return view('siswa.consultation', compact('programs'));
    }

    public function showConsultation($program_id)
    {
        $programs = auth()->user()->counselingPrograms()->with('teacher')->get();
        foreach ($programs as $program) {
            $program->unread_count = \App\Models\ConsultationMessage::where('counseling_program_id', $program->id)
                ->where('receiver_id', auth()->id())
                ->whereNull('read_at')
                ->count();
        }
        $activeProgram = $programs->where('id', $program_id)->first();
        
        if (!$activeProgram) {
            abort(404, 'Program tidak ditemukan atau Anda belum mendaftar.');
        }

        // Mark unread messages from teacher as read
        \App\Models\ConsultationMessage::where('counseling_program_id', $program_id)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = ConsultationMessage::where('counseling_program_id', $program_id)
            ->where(function($q) {
                $q->where('sender_id', auth()->id())->orWhere('receiver_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('siswa.consultation', compact('programs', 'activeProgram', 'messages'));
    }

    public function sendConsultationMessage(Request $request, $program_id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $activeProgram = auth()->user()->counselingPrograms()->where('counseling_programs.id', $program_id)->firstOrFail();

        ConsultationMessage::create([
            'counseling_program_id' => $program_id,
            'sender_id' => auth()->id(),
            'receiver_id' => $activeProgram->teacher_id,
            'message' => $request->message,
        ]);

        return back();
    }

    // Profil
    public function profile()
    {
        return view('siswa.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'photo' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();
        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
