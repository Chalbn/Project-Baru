<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\AttendanceSession;
use App\Models\AttendanceRecord;
use Carbon\Carbon;

#[Signature('app:close-expired-attendance')]
#[Description('Tutup sesi absensi yang sudah melewati batas waktu dan set siswa yang belum absen menjadi alpa')]
class CloseExpiredAttendance extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredSessions = AttendanceSession::where('is_open', true)
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', Carbon::now())
            ->with('subject.students', 'records')
            ->get();

        foreach ($expiredSessions as $session) {
            $recordedStudentIds = $session->records->pluck('student_id')->toArray();

            $recordsToInsert = [];
            foreach ($session->subject->students as $student) {
                if (!in_array($student->id, $recordedStudentIds)) {
                    $recordsToInsert[] = [
                        'attendance_session_id' => $session->id,
                        'student_id' => $student->id,
                        'status' => 'alpa',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }

            if (!empty($recordsToInsert)) {
                AttendanceRecord::insert($recordsToInsert);
            }

            $session->update(['is_open' => false]);
            $this->info("Sesi absensi ID {$session->id} berhasil ditutup.");
        }

        $this->info("Pengecekan sesi absensi kedaluwarsa selesai.");
    }
}
