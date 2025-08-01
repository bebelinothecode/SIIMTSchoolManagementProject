<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    protected $fillable = [
        // 'user_id',
        // 'parent_id',
        // 'class_id',
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
        // 'permanent_address',
        'index_number',
        'balance',
        'branch'
        // 'student_type',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function deletedUsers() 
    {
        return $this->belongsTo(User::class)->withTrashed();
    }


    public function parent() 
    {
        return $this->belongsTo(Parents::class, 'parent_id');
    }

    public function course() 
    {
        return $this->belongsTo(Grade::class, 'course_id');
    }

    public function diploma()
    {
        return $this->belongsTo(Diploma::class,'course_id_prof');
    }

    public function attendances() 
    {
        return $this->hasMany(Attendance::class);
    }

    public function borrow() 
    {
        return $this->hasMany(Book::class);
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         if (!$model->index_number) {
    //             $model->index_number = static::generateCustomId();
    //         }
    //     });
    // }

    // protected static function generateCustomId()
    // {
    //     $prefix = 'STUD-';
    //     $number = str_pad(mt_rand(1, 999999), 8, '0', STR_PAD_LEFT);

    //     // Ensure uniqueness
    //     $indexnumber = $prefix . $number;
    //     while (self::where('index_number', $indexnumber)->exists()) {
    //         $number = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    //         $indexnumber = $prefix . $number;
    //     }
    //     return $indexnumber;
    // }
}
