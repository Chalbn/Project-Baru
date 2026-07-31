<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    protected $fillable = ['teacher_id', 'date', 'status', 'notes', 'proof_file_path'];
}
