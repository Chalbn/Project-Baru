<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'teacher_id'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'subject_user', 'subject_id', 'student_id')->withTimestamps();
    }
}
