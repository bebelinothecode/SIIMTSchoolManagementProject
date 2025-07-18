<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Defer extends Model
{
    use HasFactory;

    protected $table = 'students_defer_list';

    protected $fillable = [
        'user_id',
        'level',
        'gender',
        'phone',
        'dateofbirth',
        'current_address',
        'attendance_time',
        'dateofbirth',
        'student_parent',
        'parent_phonenumber',
        'student_category',
        'course_id_prof',
        'currency_prof',
        'fees_prof',
        'duration_prof',
        'course_id',
        'currency',
        'fees',
        'level',
        'session',
        'academicyear',
        'Scholarship',
        'Scholarship_amount',
        'index_number',
        'balance',
        'branch'
        // 'student_type',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function course() 
    {
        return $this->belongsTo(Grade::class, 'course_id');
    }

    public function diploma()
    {
        return $this->belongsTo(Diploma::class,'course_id_prof');
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

}
