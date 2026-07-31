<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') return redirect('/admin/dashboard');
    if ($role === 'guru') return redirect('/guru/dashboard');
    return redirect('/siswa/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

// Teacher Routes
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/attendance', [TeacherController::class, 'attendance'])->name('attendance');
    Route::post('/attendance', [TeacherController::class, 'storeAttendance'])->name('attendance.store');
    Route::get('/attendance/self', [TeacherController::class, 'attendanceSelf'])->name('attendance.self');
    Route::post('/attendance/self', [TeacherController::class, 'storeAttendanceSelf'])->name('attendance.self.store');
    Route::get('/attendance/{session_id}', [TeacherController::class, 'showAttendance'])->name('attendance.show');
    Route::post('/attendance/{session_id}/update', [TeacherController::class, 'updateAttendanceRecords'])->name('attendance.update_records');
    
    Route::get('/assignments', [TeacherController::class, 'assignments'])->name('assignments');
    Route::post('/assignments', [TeacherController::class, 'storeAssignment'])->name('assignments.store');
    Route::post('/assignments/submissions/{id}/score', [TeacherController::class, 'scoreAssignment'])->name('assignments.score');
    
    Route::get('/exams', [TeacherController::class, 'exams'])->name('exams');
    Route::get('/grades', [TeacherController::class, 'grades'])->name('grades');
    Route::post('/grades/update', [TeacherController::class, 'updateGrade'])->name('grades.update');
    Route::get('/counseling', [TeacherController::class, 'counseling'])->name('counseling');
    Route::post('/counseling', [TeacherController::class, 'storeCounseling'])->name('counseling.store');
    Route::get('/consultation', [TeacherController::class, 'consultation'])->name('consultation');
    Route::get('/consultation/{program_id}', [TeacherController::class, 'showConsultation'])->name('consultation.show');
    Route::get('/consultation/{program_id}/{student_id}', [TeacherController::class, 'showConsultationChat'])->name('consultation.chat');
    Route::post('/consultation/{program_id}/{student_id}/send', [TeacherController::class, 'sendConsultationMessage'])->name('consultation.send');
    
    Route::get('/profile', [TeacherController::class, 'profile'])->name('profile');
    Route::post('/profile', [TeacherController::class, 'updateProfile'])->name('profile.update');
});

// Student Routes
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::post('/enroll', [StudentController::class, 'enroll'])->name('enroll');
    Route::get('/attendance', [StudentController::class, 'attendance'])->name('attendance');
    Route::post('/attendance', [StudentController::class, 'storeAttendance'])->name('attendance.store');
    
    Route::get('/assignments', [StudentController::class, 'assignments'])->name('assignments');
    Route::post('/assignments/submit', [StudentController::class, 'submitAssignment'])->name('assignments.submit');
    
    Route::get('/exams', [StudentController::class, 'exams'])->name('exams');
    Route::get('/grades', [StudentController::class, 'grades'])->name('grades');
    Route::get('/counseling', [StudentController::class, 'counseling'])->name('counseling');
    Route::post('/counseling/{id}/register', [StudentController::class, 'registerCounseling'])->name('counseling.register');
    Route::get('/consultation', [StudentController::class, 'consultation'])->name('consultation');
    Route::get('/consultation/{program_id}', [StudentController::class, 'showConsultation'])->name('consultation.show');
    Route::post('/consultation/{program_id}/send', [StudentController::class, 'sendConsultationMessage'])->name('consultation.send');
    
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    Route::post('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
});

require __DIR__.'/auth.php';