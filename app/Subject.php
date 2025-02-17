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
}
