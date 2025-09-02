<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerEvaluationSubmission extends Model
{
    use HasFactory;

    protected $table = "lecturer_evaluation_submissions";

    protected $fillable = [
        'student_id', 'course_name', 'semester', 'level'
    ];

    public function details()
    {
        return $this->hasMany(LecturerEvaluationDetail::class, 'submission_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
