<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'type',
        'teacher_id',
        'attendence_date',
        'attendence_status',
        'subject_id',
    ];

     protected $casts = [
        'attendance_date' => 'date',
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function class() {
        return $this->belongsTo(Grade::class);
    }

    public function subject()
    {
        return $this->belongsTo(Diploma::class);
    }
}
