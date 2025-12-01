<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    use HasFactory;

    protected $table = 'teacher_subject';

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'num_of_sessions',
        'aca_prof',
        'remaining_sessions'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Diploma::class,'subject_id');
    }

    public function decrementSessions()
    {
        $num = intval($this->remaining_sessions);

        if ($num > 0) {
            $this->update(['remaining_sessions' => $num - 1]);
        }
    }
}
