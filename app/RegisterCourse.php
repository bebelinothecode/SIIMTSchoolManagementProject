<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterCourse extends Model
{
    use HasFactory;

    protected $table = 'register_courses';

    protected $fillable = ['student_id', 'level', 'semester', 'subjects_id','course_id'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}
