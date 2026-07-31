<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    protected $fillable = ['subject_id', 'date', 'is_open', 'expires_at'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function records()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
