<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $table = 'student_enquires';

    protected $fillable = [
        'name',
        'telephone_number',
        'interested_course',
        'type_of_course',
        'expected_start_date',
        'bought_forms',
        'currency',
        'amount',
        'branch',
        'User',
        'receipt_number',
        'course_id',
        'diploma_id',
        'source_of_enquiry',
        'preferred_time',
        'method_of_payment'
    ];

    use HasFactory;

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function course()
    {
        return $this->belongsTo(Grade::class, 'course_id');
    }

    public function diploma()
    {
        return $this->belongsTo(Diploma::class, 'diploma_id');
    }
}

