<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Subject;
use App\Models\AttendanceSession;
use App\Models\TeacherAttendance;
use App\Models\Assignment;
use App\Models\Exam;
use App\Models\CounselingProgram;
use App\Models\ConsultationMessage;
use App\Models\User;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $subjects = auth()->user()->taughtSubjects()->with('students')->get();
        return view('guru.dashboard', compact('subjects'));
    }

    // Absensi Siswa
    public function attendance()
    {
        \Illuminate\Support\Facades\Artisan::call('app:close-expired-attendance');

        $subjects = auth()->user()->taughtSubjects;
        $subjectIds = $subjects->pluck('id');
        $attendances = AttendanceSession::whereIn('subject_id', $subjectIds)->orderBy('created_at', 'desc')->get();
        return view('guru.attendance', compact('subjects', 'attendances'));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'expires_time' => 'required|date_format:H:i',
        ]);

        $subject = auth()->user()->taughtSubjects()->firstOrFail();

        $expires_at = \Carbon\Carbon::parse($request->date . ' ' . $request->expires_time);

        AttendanceSession::create([
            'subject_id' => $subject->id,
            'date' => $request->date,
            'is_open' => true,
            'expires_at' => $expires_at,
        ]);

        return back()->with('success', 'Sesi absensi siswa berhasil dibuka!');
    }

    public function showAttendance($session_id)
    {
        $session = AttendanceSession::with(['subject.students', 'records.student'])->findOrFail($session_id);
        
        // Pastikan guru ini memiliki sesi ini
        if ($session->subject->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('guru.attendance_detail', compact('session'));
    }

    public function updateAttendanceRecords(Request $request, $session_id)
    {
        $session = AttendanceSession::with('subject')->findOrFail($session_id);
        
        if ($session->subject->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'attendance' => 'required|array',
            'attendance.*' => 'in:hadir,sakit,izin,alpa',
        ]);

        foreach ($request->attendance as $student_id => $status) {
            \App\Models\AttendanceRecord::updateOrCreate(
                ['attendance_session_id' => $session->id, 'student_id' => $student_id],
                ['status' => $status]
            );
        }

        return back()->with('success', 'Data absensi berhasil disimpan!');
    }

    // Absensi Guru
    public function attendanceSelf()
    {
        $attendances = TeacherAttendance::where('teacher_id', auth()->id())->orderBy('date', 'desc')->get();
        return view('guru.attendance_self', compact('attendances'));
    }

    public function storeAttendanceSelf(Request $request)
    {
        $request->validate([
            'status' => 'required|in:hadir,sakit,izin,alpa',
            'notes' => 'nullable|string',
            'proof_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $date = now()->toDateString();
        $time = now()->format('H:i:s');
        $dayOfWeek = now()->dayOfWeekIso; // 1 = Senin, ..., 6 = Sabtu, 7 = Minggu

        if ($dayOfWeek > 6) {
            return back()->withErrors(['message' => 'Absensi hanya bisa dilakukan di hari sekolah (Senin - Sabtu).']);
        }

        if (now()->format('H:i') < '07:00' || now()->format('H:i') > '16:00') {
            return back()->withErrors(['message' => 'Absensi hanya bisa dilakukan antara jam 07:00 sampai 16:00.']);
        }

        $proofFilePath = null;
        if ($request->hasFile('proof_file')) {
            $proofFilePath = $request->file('proof_file')->store('teacher-proofs', 'public');
        }

        \App\Models\TeacherAttendance::updateOrCreate(
            ['teacher_id' => auth()->id(), 'date' => $date],
            [
                'status' => $request->status,
                'notes' => $request->notes,
                'proof_file_path' => $proofFilePath,
            ]
        );

        return back()->with('success', 'Kehadiran Anda berhasil dicatat!');
    }

    // Tugas
    public function assignments()
    {
        $subjects = auth()->user()->taughtSubjects;
        $subjectIds = $subjects->pluck('id');
        $assignments = Assignment::with('submissions.student')->whereIn('subject_id', $subjectIds)->orderBy('created_at', 'desc')->get();
        return view('guru.assignments', compact('subjects', 'assignments'));
    }

    public function storeAssignment(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'expires_time' => 'required|date_format:H:i',
        ]);

        $subject = auth()->user()->taughtSubjects()->firstOrFail();
        
        $due_date = \Carbon\Carbon::parse($request->date . ' ' . $request->expires_time);

        Assignment::create([
            'subject_id' => $subject->id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $due_date,
        ]);

        return back()->with('success', 'Tugas baru berhasil ditambahkan!');
    }
    public function scoreAssignment(Request $request, $id)
    {
        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
        ]);
        $submission = \App\Models\AssignmentSubmission::findOrFail($id);
        $submission->update(['score' => $request->score]);
        return back()->with('success', 'Nilai tugas berhasil disimpan!');
    }

    // Ujian
    public function exams()
    {
        $subjects = auth()->user()->taughtSubjects;
        $subjectIds = $subjects->pluck('id');
        $exams = Exam::whereIn('subject_id', $subjectIds)->orderBy('created_at', 'desc')->get();
        return view('guru.exams', compact('subjects', 'exams'));
    }

    // Nilai
    public function grades()
    {
        $subjects = auth()->user()->taughtSubjects()->with(['assignments.submissions', 'students'])->get();
        return view('guru.grades', compact('subjects'));
    }

    public function updateGrade(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:assignment_submissions,id',
            'score' => 'required|numeric|min:0|max:100',
        ]);
        $submission = \App\Models\AssignmentSubmission::findOrFail($request->submission_id);
        $submission->update(['score' => $request->score]);
        return back()->with('success', 'Nilai tugas berhasil diperbarui!');
    }

    // Bimbingan
    public function counseling()
    {
        $programs = CounselingProgram::with('students')->where('teacher_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('guru.counseling', compact('programs'));
    }

    public function storeCounseling(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:lomba,beasiswa,lainnya',
            'description' => 'required|string',
            'target_students' => 'nullable|string',
        ]);

        CounselingProgram::create([
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'target_students' => $request->target_students,
            'teacher_id' => auth()->id(),
        ]);

        return back()->with('success', 'Program bimbingan/beasiswa berhasil ditambahkan!');
    }

    // Konsultasi
    public function consultation()
    {
        $programs = auth()->user()->createdCounselingPrograms()->with('students')->get();
        foreach ($programs as $program) {
            foreach ($program->students as $student) {
                $student->unread_count = \App\Models\ConsultationMessage::where('counseling_program_id', $program->id)
                    ->where('sender_id', $student->id)
                    ->where('receiver_id', auth()->id())
                    ->whereNull('read_at')
                    ->count();
            }
        }
        return view('guru.consultation', compact('programs'));
    }

    public function showConsultation($program_id)
    {
        $programs = auth()->user()->createdCounselingPrograms()->with('students')->get();
        foreach ($programs as $program) {
            foreach ($program->students as $student) {
                $student->unread_count = \App\Models\ConsultationMessage::where('counseling_program_id', $program->id)
                    ->where('sender_id', $student->id)
                    ->where('receiver_id', auth()->id())
                    ->whereNull('read_at')
                    ->count();
            }
        }
        $activeProgram = $programs->where('id', $program_id)->first();
        
        if (!$activeProgram) {
            abort(404);
        }

        return view('guru.consultation', compact('programs', 'activeProgram'));
    }

    public function showConsultationChat($program_id, $student_id)
    {
        $programs = auth()->user()->createdCounselingPrograms()->with('students')->get();
        foreach ($programs as $program) {
            foreach ($program->students as $student) {
                $student->unread_count = \App\Models\ConsultationMessage::where('counseling_program_id', $program->id)
                    ->where('sender_id', $student->id)
                    ->where('receiver_id', auth()->id())
                    ->whereNull('read_at')
                    ->count();
            }
        }
        $activeProgram = $programs->where('id', $program_id)->first();
        
        if (!$activeProgram) {
            abort(404);
        }

        $activeStudent = $activeProgram->students->where('id', $student_id)->first();
        if (!$activeStudent) {
            abort(404);
        }

        // Mark unread messages from this student as read
        ConsultationMessage::where('counseling_program_id', $program_id)
            ->where('sender_id', $student_id)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = ConsultationMessage::where('counseling_program_id', $program_id)
            ->where(function($q) use ($student_id) {
                $q->where('sender_id', $student_id)->where('receiver_id', auth()->id())
                  ->orWhere('sender_id', auth()->id())->where('receiver_id', $student_id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('guru.consultation', compact('programs', 'activeProgram', 'activeStudent', 'messages'));
    }

    public function sendConsultationMessage(Request $request, $program_id, $student_id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $activeProgram = auth()->user()->createdCounselingPrograms()->where('id', $program_id)->firstOrFail();
        $activeStudent = $activeProgram->students()->where('users.id', $student_id)->firstOrFail();

        ConsultationMessage::create([
            'counseling_program_id' => $program_id,
            'sender_id' => auth()->id(),
            'receiver_id' => $student_id,
            'message' => $request->message,
        ]);

        return back();
    }

    // Profil
    public function profile()
    {
        return view('guru.profile');
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
