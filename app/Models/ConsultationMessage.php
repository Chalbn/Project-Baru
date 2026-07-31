<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationMessage extends Model
{
    protected $fillable = [
        'counseling_program_id',
        'sender_id',
        'receiver_id',
        'message',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function counselingProgram()
    {
        return $this->belongsTo(CounselingProgram::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
