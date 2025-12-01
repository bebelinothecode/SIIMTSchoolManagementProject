<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeachingSession extends Model
{
    protected $table = 'teaching_sessions';

    protected $fillable = [
        'teacher_id',
        'diploma_id',
        'session_date',
        'session_type',
        'amount_per_session',
        'status',
    ];

    protected $casts = [
        'session_date' => 'date',
        'amount_per_session' => 'decimal:2',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function diploma()
    {
        return $this->belongsTo(Diploma::class, 'diploma_id');
    }
}