<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //This model is for the subjects

    protected $table = 'subjects';

    protected $fillable = [
        'subject_name',
        'subject_code',
        'semester',
        'level',
        'credit_hours',
        // 'course_id',
    ];

    public function teacher()
    {
        return $this->belongsToMany(Teacher::class,'teacher_subject');
    }

    public function course()
    {
        return $this->belongsTo(Grade::class);
    }

    //Assign subjects to course
    public function courses()
    {
        return $this->belongsToMany(Grade::class, 'subject_course', 'course_id', 'subject_id')->withPivot('level_id', 'semester_id') ->withTimestamps();
    }

//     public function courses()
// {
//     return $this->belongsToMany(Course::class, 'course_subject')
//         ->withPivot('level_id', 'semester_id')
//         ->withTimestamps();
// }

}
