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
    ];

    use HasFactory;
}
