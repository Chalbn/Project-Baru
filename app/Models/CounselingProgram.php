<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingProgram extends Model
{
    protected $fillable = ['title', 'description', 'type', 'target_students', 'teacher_id'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'counseling_program_user');
    }
}
