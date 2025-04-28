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
<<<<<<< HEAD
        'amount_paid',
        'User'
=======
        'amount'
>>>>>>> 75d88e5e788890fab25d7c9df02aa49016ba9a04
    ];

    use HasFactory;
}

