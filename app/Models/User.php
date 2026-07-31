<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen_at' => 'datetime',
        ];
    }

    public function taughtSubjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    public function enrolledSubjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_user', 'student_id', 'subject_id')->withTimestamps();
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class, 'student_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id');
    }

    public function counselingPrograms()
    {
        return $this->belongsToMany(CounselingProgram::class, 'counseling_program_user');
    }

    public function createdCounselingPrograms()
    {
        return $this->hasMany(CounselingProgram::class, 'teacher_id');
    }
}