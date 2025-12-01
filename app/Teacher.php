<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'gender',
        'phone',
        'dateofbirth',
        'current_address',
        'permanent_address',
        'subject_id',
        'employment_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    // public function subjects()
    // {
    //     return $this->belongsToMany(Subject::class,'teacher_subject')->withTimestamps();
    // }

    public function classes()
    {
        return $this->hasMany(Grade::class);
    }

    public function students() 
    {
        return $this->classes()->withCount('students');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function subjectAssignments(): HasMany
    {
        return $this->hasMany(TeacherSubject::class, 'teacher_id');
    }

    public function subjects()
    {
        return $this->hasMany(TeacherSubject::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments()
    {
        return $this->hasMany(TeacherPayment::class);
    }

    public function getSubjectsWithRemainingSessions()
    {
        return $this->subjects()
            ->where('remaining_sessions', '>', 0)
            ->with('subject')
            ->get();
    }

      public function attendancesForPeriod($month, $year)
    {
        return $this->attendances()
            ->whereYear('attendence_date', $year)
            ->whereMonth('attendence_date', $month)
            ->where('attendence_status', 'present');
    }
}
